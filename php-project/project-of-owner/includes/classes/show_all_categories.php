<?php
class show_all_category{

	/**
	 *
	 * @return array sub categories of root category
	 */
	static function get_subs_of_root_category($cid)
	{
		global $db;
		$transceivers = array();
		$sql= "select c.categories_id as id,parent_id as pid, categories_name as name from " .TABLE_CATEGORIES . " as c left join " .
				TABLE_CATEGORIES_DESCRIPTION  ." as cd
  		on (c.categories_id = cd.categories_id)
  		where c.categories_status = 1
		and c.parent_id = ".(int)$cid."
  		and cd.language_id = " .(int)$_SESSION['languages_id'] . "
  		order by c.sort_order ";
		$result = $db->Execute($sql);
		while (!$result->EOF){
			$transceivers [] = array(
					'id'=>$result->fields['id'],
					'name'=>$result->fields['name']
					);
			$result->MoveNext();
		}
		return $transceivers;
	}


	static function display_subcategories($categories){
		$html = '';

		 for ($i = 0,$n =sizeof($categories); $i < $n;$i++){

                 $id = $categories[$i]['id'];
                 $name = $categories[$i]['name'];
                 $subs = $categories[$i]['subs'];
                 //$html .='<dl>';
                 $html .='<dd><a class="leftbg" href="'.zen_href_link(FILENAME_DEFAULT,'&cPath='.$id).'">'. $name.'</a></dd>';
				//$html .='</dl>';
               if (0<$i && 0 == ($i+1) % 4 ) {
               	  //$html .='<div class="ccc"></div>';
               }

		 }

		return $html;
	}

	static function show_categories(){

		global $db;

		$html = '';
		$arr = array();
		$sql= "select c.categories_id as id from " .TABLE_CATEGORIES . " as c left join " .
				TABLE_CATEGORIES_DESCRIPTION  ." as cd
  		on (c.categories_id = cd.categories_id)
  		where c.categories_status = 1
  		and cd.language_id = " .(int)$_SESSION['languages_id'] . "
  		and c.parent_id = 0
  		order by c.sort_order ";

		$result = $db->Execute($sql);
		if ($result->RecordCount()){
			while (!$result->EOF){
				$arr [] = $result->fields['id'];
				$result->MoveNext();

			}
		}
		$size = sizeof($arr);
		if ($size){
			$html .= '<div class="search_01 site_map_03">All CATEGORIES</div>
<div class="ccc"></div>';

		for ($i =0;$i<$size; $i++){
				if(0 == $i){
					$html .='
							<div id="categories_1" class="show_all_product show_border_right" style="padding-left:0px;display:none;" >';
							$html .=' <dl>
	                               <dt>
									<div class="view second-effect">
									<a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[0]).'"> <img alt='.zen_get_categories_name((int)$arr[0]).'  src="images/map-Offers-Fiber-Optic-Transmission.jpg"> </a>
									<div class="mask"> </div> </div>
									</dt>
	                         <dd> <h5>
									<a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[0]).'">'.zen_get_categories_name((int)$arr[0]).'</a>
	                         		 </h5> </dd>  		 ';
	               			$html .=  show_all_category::display_subcategories(show_all_category::get_subs_of_root_category((int)$arr[0]));

							$html .='
	                              </dl>  <dl> <dt><a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[1]).'"> <img alt='.zen_get_categories_name((int)$arr[1]).' src="images/map_fiber-optic-transceivers.jpg"> </a> </dt>
	                         <dd> <h5>
									<a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[1]).'">'.zen_get_categories_name((int)$arr[1]).'</a>
	                         		 </h5> </dd>  		 ';
							$html .=  show_all_category::display_subcategories(show_all_category::get_subs_of_root_category((int)$arr[1]));

							$html .='
	                              </dl>  <dl> <dt><a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[2]).'"> <img alt='.zen_get_categories_name((int)$arr[2]).' src="images/map_IMG_1582.jpg"> </a> </dt>
	                         <dd> <h5>
									<a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[2]).'">'.zen_get_categories_name((int)$arr[2]).'</a>
	                         		 </h5> </dd>  		 ';
							$html .=  show_all_category::display_subcategories(show_all_category::get_subs_of_root_category((int)$arr[2]));

							$html .='</dl>';
							$html .= '</div>';

				}else if(7 == $i){
				$html .= '
						<div id="categories_2" class="show_all_product" style="display:none;">';
							$html .=' <dl>
	                               <dt> <a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[6]).'"> <img alt='.zen_get_categories_name((int)$arr[6]).' src="images/map-Connectors-Adapters.jpg"> </a> </dt>';
	                         $html .='<dd> <h5>
									<a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[6]).'">'.zen_get_categories_name((int)$arr[6]).'</a>
	                         		 </h5> </dd>  		 ';

	               			$html .=  show_all_category::display_subcategories(show_all_category::get_subs_of_root_category((int)$arr[6]));

							$html .='
	                              </dl>  <dl><dt> <a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[7]).'"> <img alt='.zen_get_categories_name((int)$arr[7]).' src="images/map-Fiber-Testers.jpg"> </a> </dt>';

							$html .='<dd> <h5>
									<a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[7]).'">'.zen_get_categories_name((int)$arr[7]).'</a>
	                         		 </h5> </dd>  		 ';
							$html .=  show_all_category::display_subcategories(show_all_category::get_subs_of_root_category((int)$arr[7]));

							$html .='
	                              </dl>  <dl><dt> <a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[8]).'"> <img alt='.zen_get_categories_name((int)$arr[8]).' src="images/map-Copper-Networks.jpg"> </a> </dt>';

							$html .='<dd> <h5>
									<a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[8]).'">'.zen_get_categories_name((int)$arr[8]).'</a>
	                         		 </h5> </dd>  		 ';
							$html .=  show_all_category::display_subcategories(show_all_category::get_subs_of_root_category((int)$arr[8]));

							$html .='
	                              </dl>';

							$html .= '</div>';
				}else if(4 == $i){

// 					$html .=' <dl><dd>';
// 					$html .=  show_all_category::display_subcategories(show_all_category::get_subs_of_root_category((int)$arr[3]));
// 					$html .='</dd></dl>
// 							<dl>
// 	                               <dt> <a href="javascript:;"> <img src=""> </a> </dt>
// 	                         <dd> <h5>
// 									<a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[4]).'">'.zen_get_categories_name((int)$arr[4]).'</a>
// 	                         		 </h5> </dd>  		 ';

					$html .='
							<div id="categories_3" class="show_all_product show_border_right" style="display:none;">';
					$html .=' <dl>
	                               <dt> <a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[4]).'"> <img alt='.zen_get_categories_name((int)$arr[4]).' src="images/map-Fiber-Optic-Patch-Cables.jpg"> </a> </dt>
	                         <dd> <h5>
									<a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[4]).'">'.zen_get_categories_name((int)$arr[4]).'</a>
	                         		 </h5> </dd>  		 ';
					$html .=  show_all_category::display_subcategories(show_all_category::get_subs_of_root_category((int)$arr[4]));

					$html .='
	                              </dl>  <dl> <dt><a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[5]).'"> <img alt='.zen_get_categories_name((int)$arr[5]).' src="images/map-Cables-Management.jpg"> </a> </dt>
	                         <dd> <h5>
									<a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[5]).'">'.zen_get_categories_name((int)$arr[5]).'</a>
	                         		 </h5> </dd>  		 ';
					$html .=  show_all_category::display_subcategories(show_all_category::get_subs_of_root_category((int)$arr[5]));

					$html .='</dl>';
					$html .= '</div>';
				}else if(2 == $i){

					$html .='
							<div id="categories_4" class="show_all_product show_border_right" style="display:none;">';
// 					$html .=' <dl>
// 	                               <dt> <a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[2]).'"> <img src=""> </a> </dt>
// 	                         <dd> <h5>
// 									<a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[2]).'">'.zen_get_categories_name((int)$arr[2]).'</a>
// 	                         		 </h5> </dd>  		 ';
// 					$html .=  show_all_category::display_subcategories(show_all_category::get_subs_of_root_category((int)$arr[2]));
// 					if ((int)$arr[2]) {
// 						$html .='<div class="ccc"></div>';
// 					}		 </dl>

					$html .='
	                              <dl> <dt><a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[3]).'"> <img alt='.zen_get_categories_name((int)$arr[3]).' src="images/map_tight-buffered-fibre.jpg"> </a> </dt>
	                         <dd> <h5>
									<a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[3]).'">'.zen_get_categories_name((int)$arr[3]).'</a>
	                         		 </h5> </dd>  		 ';
					$html .=  show_all_category::display_subcategories(show_all_category::get_subs_of_root_category((int)$arr[3]));

					$html .='</dl>';

					$html .= '</div>';
				}

			}

			//new all categories for small size
				for ($n =0;$n<$size; $n++){
				if(0 == $n){
					$html .='
							<div id="categories_01" class="show_all_product show_border_right" style="padding-left:0px;">';
							$html .=' <dl>
	                               <dt>
									<div class="view second-effect">
									<a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[1]).'"> <img alt='.zen_get_categories_name((int)$arr[1]).' src="images/map_fiber-optic-transceivers.jpg"> </a>
									<div class="mask"> </div> </div>
									</dt>
	                         <dd> <h5>
									<a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[1]).'">'.zen_get_categories_name((int)$arr[1]).'</a>
	                         		 </h5> </dd>  		 ';
	               			$html .=  show_all_category::display_subcategories(show_all_category::get_subs_of_root_category((int)$arr[1]));

							$html .='
	                              </dl>  <dl> <dt><a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[2]).'"> <img alt='.zen_get_categories_name((int)$arr[2]).' src="images/IMG_1582.png"> </a> </dt>
	                         <dd> <h5>
									<a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[2]).'">'.zen_get_categories_name((int)$arr[2]).'</a>
	                         		 </h5> </dd>  		 ';
							$html .=  show_all_category::display_subcategories(show_all_category::get_subs_of_root_category((int)$arr[2]));

							$html .='</dl>';
							$html .= '</div>';

				}else if(7 == $n){
				$html .= '
						<div id="categories_02" class="show_all_product show_border_right" >';
							$html .=' <dl>
	                               <dt> <a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[5]).'"> <img alt='.zen_get_categories_name((int)$arr[5]).' src="images/map-Cables-Management.jpg"> </a> </dt>';
	                         $html .='<dd> <h5>
									<a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[5]).'">'.zen_get_categories_name((int)$arr[5]).'</a>
	                         		 </h5> </dd>  		 ';

	               			$html .=  show_all_category::display_subcategories(show_all_category::get_subs_of_root_category((int)$arr[5]));
						if ((int)$arr[5]) {
							$html .='<div class="ccc"></div>';
						}

					     $html .='
	                              </dl>  <dl> <dt><a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[6]).'"> <img alt='.zen_get_categories_name((int)$arr[6]).' src="images/map-Connectors-Adapters.jpg"> </a> </dt>
	                         <dd> <h5>
									<a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[6]).'">'.zen_get_categories_name((int)$arr[6]).'</a>
	                         		 </h5> </dd>  		 ';
					     $html .=  show_all_category::display_subcategories(show_all_category::get_subs_of_root_category((int)$arr[6]));
							$html .='
	                              </dl>';

							$html .= '</div>';
				}
				else if(8 == $n){
				$html .= '
						<div id="categories_03" class="show_all_product" >';

							$html .='  <dl><dt> <a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[7]).'"> <img alt='.zen_get_categories_name((int)$arr[7]).' src="images/map-Fiber-Testers.jpg"> </a> </dt>';

							$html .='<dd> <h5>
									<a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[7]).'">'.zen_get_categories_name((int)$arr[7]).'</a>
	                         		 </h5> </dd>  		 ';
							$html .=  show_all_category::display_subcategories(show_all_category::get_subs_of_root_category((int)$arr[7]));
					if ((int)$arr[7]) {
						   $html .='<div class="ccc"></div>';
					        }

					        $html .='
	                              </dl>  <dl> <dt><a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[8]).'"> <img alt='.zen_get_categories_name((int)$arr[8]).'   src="images/map-Copper-Networks.jpg"> </a> </dt>
	                         <dd> <h5>
									<a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[8]).'">'.zen_get_categories_name((int)$arr[8]).'</a>
	                         		 </h5> </dd>  		 ';
					        $html .=  show_all_category::display_subcategories(show_all_category::get_subs_of_root_category((int)$arr[8]));
							$html .='
	                              </dl>';

							$html .= '</div>';
				}

				else if(4 == $n){

					$html .='
							<div id="categories_04" class="show_all_product show_border_right" >';
					$html .=' <dl>
	                               <dt> <a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[3]).'"><img alt='.zen_get_categories_name((int)$arr[3]).' src="images/map_tight-buffered-fibre.jpg"> </a> </dt>
	                         <dd> <h5>
									<a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[3]).'">'.zen_get_categories_name((int)$arr[3]).'</a>
	                         		 </h5> </dd>  		 ';
					$html .=  show_all_category::display_subcategories(show_all_category::get_subs_of_root_category((int)$arr[3]));


					$html .='</dl>';
					$html .= '</div>';
				}else if(2 == $n){

					$html .='
							<div id="categories_05"  class="show_all_product show_border_right">';
					$html .=' <dl>
	                               <dt> <a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[0]).'"> <img alt='.zen_get_categories_name((int)$arr[0]).' src="images/map-Offers-Fiber-Optic-Transmission.jpg"> </a> </dt>
	                         <dd> <h5>
									<a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[0]).'">'.zen_get_categories_name((int)$arr[0]).'</a>
	                         		 </h5> </dd>  		 ';
					$html .=  show_all_category::display_subcategories(show_all_category::get_subs_of_root_category((int)$arr[0]));
					if ((int)$arr[0]) {
						$html .='<div class="ccc"></div>';
					}

					$html .='
	                              </dl>  <dl> <dt><a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[4]).'"> <img alt='.zen_get_categories_name((int)$arr[4]).' src="images/map-Fiber-Optic-Patch-Cables.jpg"> </a> </dt>
	                         <dd> <h5>
									<a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[4]).'">'.zen_get_categories_name((int)$arr[4]).'</a>
	                         		 </h5> </dd>  		 ';
					$html .=  show_all_category::display_subcategories(show_all_category::get_subs_of_root_category((int)$arr[4]));

					$html .='</dl>';

					$html .= '</div>';
				}

			}
		}
		return $html;
	}




}