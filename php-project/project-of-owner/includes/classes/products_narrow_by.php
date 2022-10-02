<?php
/*   author  :  melo
 *   主函数说明:
 *   1.fs_products_narrow_by_list()           应用于分类列表页面
 *   2.fs_search_products_narrow_by_list()    应用于搜索结果页面
 *   3.fs_products_narrow_by_list_of_finder() 应用于分类定制页面
 *   
 *   这三个函数基本一致,只是其中page参数,当前页面产品的筛选项,当前页面产品筛选值  不同
 */

class products_narrow_by{
    private $languages_id;

    public function __construct()
    {
        $this->languages_id = $_SESSION['languages_id']  ?  $_SESSION['languages_id'] :  1;
//        //au、uk使用英语站的数据
//        if($_SESSION['languages_code']=='au' || $_SESSION['languages_code']=='uk'){
//            $this->languages_id = 1;
//        }else{
//            $this->languages_id = $_SESSION['languages_id'];
//        }
    }

    /******** 新筛选项 bof  *********/
    function fs_products_narrow_by_list($current_category_id,$pids,$get_narrow){
      global $cPath_array;
      global $db;
	  $narrow_by_hidding = false;
      //默认展开
 	  $display_css_class = 'sidebar_06_js';
 	  $display_dd_css_class = '';
	  
      //当前已选择的筛选值代表的筛选项
//      if(is_array($get_narrow) && sizeof($get_narrow)){
//	       foreach ($get_narrow as $vn => $noID){
//	        $select_narrow_option_array [] = zen_get_narrow_by_option_id_of_values_id($noID);
//	       }
//      }
	  
      $narrow_by_html = '';
	  $category_options = $this->fs_category_products_narrow_option($pids,'cpath',$current_category_id);  //分类产品拥有的筛选项
        $nar = array();
        if (fs_get_data_from_db_fields('products_narrow_by_options_id', 'products_narrow_by_options_to_categories_sort', 'categories_id=' . $current_category_id, '')) {
            $sql = "select products_narrow_by_options_id from products_narrow_by_options_to_categories_sort where categories_id=" . $current_category_id . "
                  order by products_options_sort,options_categories_sort_id";
            $result = $db->Execute($sql);
            if ($result->RecordCount()) {
                while (!$result->EOF) {
                    $nar[] = $result->fields['products_narrow_by_options_id'];
                    $result->MoveNext();
                }
            }
            $narrow_by_options = $nar;
        } else {
            if($current_category_id == 1068){
                $narrow_by_options = $this->sort_order_narrow_by_options($category_options);  //筛选项排序
                $narrow_by_options = array_reverse($narrow_by_options);
            }else{
                $narrow_by_options = $this->sort_order_narrow_by_options($category_options);  //筛选项排序
            }
        }
	  
	  //$narrow_by_options = $this->sort_order_narrow_by_options($category_options);  //筛选项排序
	  $trim = true;
	  //筛选项循环
	  $get_narrow_option = array();
	  if(sizeof($get_narrow)){
	      for($ni = 0; $ni< sizeof($get_narrow);$ni++){
				  $get_narrow_option [] = $this->fs_narrow_by_option_id_of_values_id($get_narrow[$ni]);
		  }
	  }
	 
	  $narrow_css ='';$css_type='';
	  foreach ($narrow_by_options as $i => $oID){
	  	$products_narrow_value  = $this->fs_narrow_by_values_by_select_products($oID,$pids);   //当前产品,当前筛选项下拥有的筛选值
            $sql ="select default_not_show from products_narrow_by_options where language_id = ".$this->languages_id." and products_narrow_by_options_id=".$oID;

            $default_not_show_data = $db->getAll($sql);
            $default_show = 1;
            if($default_not_show_data){
                $default_not_show = $default_not_show_data[0]['default_not_show'];
                if($default_not_show !== '') {
                    $default_not_show_arr = explode(',', $default_not_show);
                    if (in_array($current_category_id, $default_not_show_arr)) {
                        $default_show = 0;
                    }
                }
            }

	    if(sizeof($products_narrow_value) <2 && !in_array($oID,$get_narrow_option)){

	    }else{
	  
	  	//剔除该筛选项中被选中的值,判断此时的情况下,产品中对应的筛选项的值
	    $replace_option = array();
	  	for($ni = 0; $ni< sizeof($get_narrow);$ni++){
			    if($oID == $get_narrow_option[$ni]){ //当前筛选项下有筛选值选中时,替换
				}else{
				   	$replace_option [] = $get_narrow[$ni];
				}
		}
		
	    // 该分类下,先剔除当前筛选项,得到其他筛选后的产品,再从产品中判断该筛选项的值
		if(sizeof($get_narrow)){
		$narrow_option_values = $this->zen_get_count_products_of_alnoe_narrow($replace_option,$oID,$current_category_id);
		}

	     if(in_array($oID,$get_narrow_option) || $default_show){ //展开
	       $display_css_class = 'sidebar_06_js';
 	       $display_dd_css_class = '';
	     }else{
	       $display_css_class = 'sidebarForJS';
	       $display_dd_css_class = 'display_none';
	     }

		 $css_type = $this->fs_narrow_by_opions_css_type($oID);   //筛选项样式
		 switch ($css_type){
		 case '2':
		 $narrow_css  ='two_column';
		 break;
		 case '3':
		 $narrow_css  ='three_column';
		 break;
		 default:
		 $narrow_css  ='';
		 break;
		 }
		
	     $narrow_by_html .= '<dl class="select '.$narrow_css.'"> ';
	   
		 $narrow_by_html .= '<dt>
		                     <a class="'.$display_css_class.'" href="javascript:;">'.$this->get_products_narrow_by_option_name($oID).'</a>
		                    </dt>';
		 
		$narrow_by_values = $this->fs_narrow_by_opions_values_by_oID_products($oID);   //分类产品筛选项下的筛选值
		
		//筛选后的产品,拥有的筛选值.用来识别没有无结果的筛选值,隐藏
		
		if(sizeof($narrow_by_values)){
		$narrow_by_values = $this->sort_order_narrow_by_values($narrow_by_values);     //筛选值排序
		$nvi = 0;$cDIV = false;$hideNV=false;
		foreach ($narrow_by_values as $ii => $vID){
   			$is_current= $narrow_get_parmas_string = '';
			//$page = FILENAME_NARROW;
			$page = FILENAME_DEFAULT;
			$except_values = array('cPath','narrow');
			$new_narrow_by_array = array();
			$href =$name=$count_of_narrow_by_products= '';
			$class='';
			if (zen_not_null($get_narrow)) {
				if (in_array($vID,$get_narrow)) {  //已选择的筛选值,添加样式
					$is_current = 'xiand';
					$class = $is_current;
				}							
			}
			else {
				$new_narrow_by_array = array();
			}
			$_GET['narrow']= $new_narrow_by_array;
						
			$name = $this->get_option_values_name($vID);


			$narrow_url = '';
			$replace_narrow = array();
			
			//其他参数 : 排序,页数,标签
		if (isset($_GET['sort_order']) && $_GET['sort_order']) $narrow_url .='&sort_order='.$_GET['sort_order'].'';
		if (isset($_GET['count']) && intval($_GET['count'])) $narrow_url .='&count='.$_GET['count'];
        if (isset($_GET['settab']) ){ $narrow_url .='&settab='.$_GET['settab']; }

			//如果下一步选择的筛选值和已选择的筛选值属于同一个筛选项,那么新的URL 是将选择的筛选值替换已选择的筛选值
			for($ni = 0; $ni< sizeof($get_narrow);$ni++){
			    if($vID == $get_narrow[$ni]){    //取消已选择的筛选值                                         
			        $narrow_url .='';
			    }else if($oID == $get_narrow_option[$ni]){ //当前筛选项下有筛选值选中时,替换
					$narrow_url .='&narrow[]='.$vID;
				}else{
					$narrow_url .='&narrow[]='.$get_narrow[$ni];
				}
			}
			
			if($get_narrow_option){
				if(!in_array($oID,$get_narrow_option)){        //没有勾选的筛选项
				 if(!in_array($vID,$products_narrow_value)){   //如果当前产品没有未勾选筛选项中的筛选值,则筛选值不显示
				 $hideNV = true;
				 }else{
				 $hideNV = false;
				 $nvi ++;
				 }  
				}else{   //同选中的筛选项,替换之后会有产品,才能显示
				   //if(sizeof($get_narrow_option) > 1){
				     //交叉筛选时,才用这个.两个及以上的筛选
				     if(in_array($vID,$narrow_option_values)){  //筛选条件下,是否有产品
				     $hideNV = false;
				     $nvi ++;
				     }else{
				     $hideNV = true;
				     }
	 			   //}
				}
			   //过滤该option下的vid  , 从产品中查询是否有该vID
				if(!in_array($oID,$get_narrow_option)){  //除去当前筛选,选择新的筛选值时,新增URL参数
				  $narrow_url .='&narrow[]='.$vID;
				}
			}else{
				 if(!in_array($vID,$products_narrow_value)){   //如果当前产品没有未勾选筛选项中的筛选值,则筛选值不显示
				 $hideNV = true;
				 }else{
				 $hideNV = false;
				 $nvi ++;
				 }
			  $narrow_url .='&narrow[]='.$vID;
			}

		  //$narrow_item = $this->get_all_get_params($except_values,$trim);

          $href= zen_href_link($page,$narrow_url.'&cPath='.$current_category_id);
		    if(!$hideNV){
		        /*
		        if($nvi == 15){
				$cDIV = true;
			    $narrow_by_html .= '<div class="all_subcategories_list" id="narrow_pulldown" style="display:none;">';
				}
				*/
		        $narrow_by_html .= '<dd class="' .$class. ' '.$display_dd_css_class.'" '.'> ';
		        $narrow_by_html .= '<a href="'.$href.'">'.$name.'</a> ';
				$narrow_by_html .= '</dd>';
		    }	
		  }  
	  }
		  //  end of narrow values foreach
		  /*
         if($cDIV){
		  $narrow_by_html .= '</div>';
          $narrow_by_html .= '<div id="pulldown_narrow" class="sidebar_more"><a id="pulldownNV" href="javascript:void(0);">Show More</a></div>';
         }
         */
         $narrow_by_html .= '</dl>';
	  }
    }//只有一个筛选值的 筛选项不显示 
	  //  end of narrow option foreach
      //光模块第三级分类不需要下面这段
		if (5 < strlen(strip_tags($narrow_by_html)) ) {
			$narrow_by_html = '<div class="sidebar_06">'.$narrow_by_html .'</div>	';
		}
	  return $narrow_by_html;		
    }

	//针对产品列表页单独的分类筛选项
	function fs_products_left_list($current_category_id,$pids,$get_narrow){
		global $cPath_array;
		global $db;
		$narrow_by_hidding = false;
		//默认展开
		$display_css_class = 'sidebar_06_js';
		$display_dd_css_class = '';

		//当前已选择的筛选值代表的筛选项
//      if(is_array($get_narrow) && sizeof($get_narrow)){
//	       foreach ($get_narrow as $vn => $noID){
//	        $select_narrow_option_array [] = zen_get_narrow_by_option_id_of_values_id($noID);
//	       }
//      }

		$narrow_by_html = '';
		$category_options = $this->fs_category_products_narrow_option($pids,'cpath',$current_category_id);  //分类产品拥有的筛选项
		$nar = array();
		if (fs_get_data_from_db_fields('products_narrow_by_options_id', 'products_narrow_by_options_to_categories_sort', 'categories_id=' . $current_category_id, '')) {
			$sql = "select products_narrow_by_options_id from products_narrow_by_options_to_categories_sort where categories_id=" . $current_category_id . " and language_id=1 order by products_options_sort,options_categories_sort_id";
			$result = $db->Execute($sql);
			if ($result->RecordCount()) {
				while (!$result->EOF) {
					$nar[] = $result->fields['products_narrow_by_options_id'];
					$result->MoveNext();
				}
			}
			$narrow_by_options = $nar;
		} else {
			if($current_category_id == 1068){
				$narrow_by_options = $this->sort_order_narrow_by_options($category_options);  //筛选项排序
				$narrow_by_options = array_reverse($narrow_by_options);
			}else{
				$narrow_by_options = $this->sort_order_narrow_by_options($category_options);  //筛选项排序
			}
		}

		//$narrow_by_options = $this->sort_order_narrow_by_options($category_options);  //筛选项排序
		$trim = true;
		//筛选项循环
		$get_narrow_option = array();
		if(sizeof($get_narrow)){
			for($ni = 0; $ni< sizeof($get_narrow);$ni++){
				$get_narrow_option [] = $this->fs_narrow_by_option_id_of_values_id($get_narrow[$ni]);
			}
		}

		$narrow_css ='';$css_type='';
		foreach ($narrow_by_options as $i => $oID){
			$products_narrow_value  = $this->fs_narrow_by_values_by_select_products($oID,$pids);   //当前产品,当前筛选项下拥有的筛选值
			$sql ="select default_not_show from products_narrow_by_options where language_id = ".$this->languages_id." and products_narrow_by_options_id=".$oID;

			$default_not_show_data = $db->getAll($sql);
			$default_show = 1;
			if($default_not_show_data){
				$default_not_show = $default_not_show_data[0]['default_not_show'];
				if($default_not_show !== '') {
					$default_not_show_arr = explode(',', $default_not_show);
					if (in_array($current_category_id, $default_not_show_arr)) {
						$default_show = 0;
					}
				}
			}

			if(sizeof($products_narrow_value) <2 && !in_array($oID,$get_narrow_option)){

			}else{

				//剔除该筛选项中被选中的值,判断此时的情况下,产品中对应的筛选项的值
				$replace_option = array();
				for($ni = 0; $ni< sizeof($get_narrow);$ni++){
					if($oID == $get_narrow_option[$ni]){ //当前筛选项下有筛选值选中时,替换
					}else{
						$replace_option [] = $get_narrow[$ni];
					}
				}

				// 该分类下,先剔除当前筛选项,得到其他筛选后的产品,再从产品中判断该筛选项的值
				if(sizeof($get_narrow)){
					$narrow_option_values = $this->zen_get_count_products_of_alnoe_narrow($replace_option,$oID,$current_category_id);
				}

				if(in_array($oID,$get_narrow_option) || $default_show){ //展开
					$display_css_class = 'sidebar_06_js';
					$display_dd_css_class = '';
				}else{
					$display_css_class = 'sidebarForJS';
					$display_dd_css_class = 'display_none';
				}

				$css_type = $this->fs_narrow_by_opions_css_type($oID);   //筛选项样式
				switch ($css_type){
					case '2':
						$narrow_css  ='two_column';
						break;
					case '3':
						$narrow_css  ='three_column';
						break;
					default:
						$narrow_css  ='';
						break;
				}

				$narrow_by_html .= '<dl class="listSel '.$narrow_css.'"> ';

				$narrow_by_html .= '<dt>'.$this->get_products_narrow_by_option_name($oID).'
		                    <i class="up_down_ic iconfont choosez">&#xf057</i></dt>';

				$narrow_by_values = $this->fs_narrow_by_opions_values_by_oID_products($oID);   //分类产品筛选项下的筛选值

				//筛选后的产品,拥有的筛选值.用来识别没有无结果的筛选值,隐藏

				if(sizeof($narrow_by_values)){
					$narrow_by_values = $this->sort_order_narrow_by_values($narrow_by_values);     //筛选值排序
					$nvi = 0;$cDIV = false;$hideNV=false;
					foreach ($narrow_by_values as $ii => $vID){
						$is_current= $narrow_get_parmas_string = '';
						//$page = FILENAME_NARROW;
						$page = FILENAME_DEFAULT;
						$except_values = array('cPath','narrow');
						$new_narrow_by_array = array();
						$href =$name=$count_of_narrow_by_products= '';
						$class='';
						if (zen_not_null($get_narrow)) {
							if (in_array($vID,$get_narrow)) {  //已选择的筛选值,添加样式
								$is_current = 'choosez';
								$class = $is_current;
							}
						}
						else {
							$new_narrow_by_array = array();
						}
						$_GET['narrow']= $new_narrow_by_array;

						$name = $this->get_option_values_name($vID);


						$narrow_url = '';
						$replace_narrow = array();

						//其他参数 : 排序,页数,标签
						if (isset($_GET['sort_order']) && $_GET['sort_order']) $narrow_url .='&sort_order='.$_GET['sort_order'].'';
						if (isset($_GET['count']) && intval($_GET['count'])) $narrow_url .='&count='.$_GET['count'];
						if (isset($_GET['settab']) ){ $narrow_url .='&settab='.$_GET['settab']; }

						//如果下一步选择的筛选值和已选择的筛选值属于同一个筛选项,那么新的URL 是将选择的筛选值替换已选择的筛选值
						for($ni = 0; $ni< sizeof($get_narrow);$ni++){
							if($vID == $get_narrow[$ni]){    //取消已选择的筛选值
								$narrow_url .='';
							}else if($oID == $get_narrow_option[$ni]){ //当前筛选项下有筛选值选中时,替换
								$narrow_url .='&narrow[]='.$vID;
							}else{
								$narrow_url .='&narrow[]='.$get_narrow[$ni];
							}
						}

						if($get_narrow_option){
							if(!in_array($oID,$get_narrow_option)){        //没有勾选的筛选项
								if(!in_array($vID,$products_narrow_value)){   //如果当前产品没有未勾选筛选项中的筛选值,则筛选值不显示
									$hideNV = true;
								}else{
									$hideNV = false;
									$nvi ++;
								}
							}else{   //同选中的筛选项,替换之后会有产品,才能显示
								//if(sizeof($get_narrow_option) > 1){
								//交叉筛选时,才用这个.两个及以上的筛选
								if(in_array($vID,$narrow_option_values)){  //筛选条件下,是否有产品
									$hideNV = false;
									$nvi ++;
								}else{
									$hideNV = true;
								}
								//}
							}
							//过滤该option下的vid  , 从产品中查询是否有该vID
							if(!in_array($oID,$get_narrow_option)){  //除去当前筛选,选择新的筛选值时,新增URL参数
								$narrow_url .='&narrow[]='.$vID;
							}
						}else{
							if(!in_array($vID,$products_narrow_value)){   //如果当前产品没有未勾选筛选项中的筛选值,则筛选值不显示
								$hideNV = true;
							}else{
								$hideNV = false;
								$nvi ++;
							}
							$narrow_url .='&narrow[]='.$vID;
						}

						//$narrow_item = $this->get_all_get_params($except_values,$trim);

						$href= zen_href_link($page,$narrow_url.'&cPath='.$current_category_id);
						if(!$hideNV){
							/*
                            if($nvi == 15){
                            $cDIV = true;
                            $narrow_by_html .= '<div class="all_subcategories_list" id="narrow_pulldown" style="display:none;">';
                            }
                            */
							$narrow_by_html .= '<dd class="listLi '.$class.' hide"> ';
							$narrow_by_html .= '<a href="'.$href.'">'.$name.'</a> ';
							$narrow_by_html .= '</dd>';
						}
					}
				}
				//  end of narrow values foreach
				/*
               if($cDIV){
                $narrow_by_html .= '</div>';
                $narrow_by_html .= '<div id="pulldown_narrow" class="sidebar_more"><a id="pulldownNV" href="javascript:void(0);">Show More</a></div>';
               }
               */
				$narrow_by_html .= '</dl>';
			}
		}//只有一个筛选值的 筛选项不显示
		//  end of narrow option foreach
		//光模块第三级分类不需要下面这段
		// if (5 < strlen(strip_tags($narrow_by_html)) ) {
		// 	$narrow_by_html = '<div class="">'.$narrow_by_html .'</div>	';
		// }
		return $narrow_by_html;
	}

    //针对产品列表页单独的分类最新筛选项
    //$current_category_id 分类ID
    //$pids 产品ID array()
    //$type 区分pc端 m端 1pc 2m端
    function fs_products_header_new_list($current_category_id,$pids,$get_narrow,$type){
        global $cPath_array;
        global $db;
        $narrow_by_hidding = false;
        //默认展开
        $display_css_class = 'sidebar_06_js';
        $display_dd_css_class = '';

        //当前已选择的筛选值代表的筛选项
//      if(is_array($get_narrow) && sizeof($get_narrow)){
//	       foreach ($get_narrow as $vn => $noID){
//	        $select_narrow_option_array [] = zen_get_narrow_by_option_id_of_values_id($noID);
//	       }
//      }
        $narrow_by_html = '';
        $category_options = $this->fs_category_products_narrow_option($pids,'cpath',$current_category_id);  //分类产品拥有的筛选项
        $nar = array();
        if (fs_get_data_from_db_fields('products_narrow_by_options_id', 'products_narrow_by_options_to_categories_sort', 'categories_id=' . $current_category_id, '')) {
            $sql = "select products_narrow_by_options_id from products_narrow_by_options_to_categories_sort where categories_id=" . $current_category_id . " and language_id=1
                  order by products_options_sort,options_categories_sort_id";
            $result = $db->Execute($sql);
            if ($result->RecordCount()) {
                while (!$result->EOF) {
                    $nar[] = $result->fields['products_narrow_by_options_id'];
                    $result->MoveNext();
                }
            }
            $narrow_by_options = $nar;
        } else {
            if($current_category_id == 1068){
                $narrow_by_options = $this->sort_order_narrow_by_options($category_options);  //筛选项排序
                $narrow_by_options = array_reverse($narrow_by_options);
            }else{
                $narrow_by_options = $this->sort_order_narrow_by_options($category_options);  //筛选项排序
            }
        }
        //$narrow_by_options = $this->sort_order_narrow_by_options($category_options);  //筛选项排序
        $trim = true;
        //筛选项循环
        $get_narrow_option = array();
        if(sizeof($get_narrow)){
            for($ni = 0; $ni< sizeof($get_narrow);$ni++){
                $get_narrow_option [] = $this->fs_narrow_by_option_id_of_values_id($get_narrow[$ni]);
            }
        }
        $Parent = 2;
        foreach ($narrow_by_options as $i => $oID){
            $products_narrow_value  = $this->fs_narrow_by_values_by_select_products($oID,$pids);   //当前产品,当前筛选项下拥有的筛选值
            $sql ="select default_not_show from products_narrow_by_options where language_id = ".$this->languages_id." and products_narrow_by_options_id=".$oID;
            $default_not_show_data = $db->getAll($sql);
            $default_show = 1;
            if($default_not_show_data){
                $default_not_show = $default_not_show_data[0]['default_not_show'];
                if($default_not_show !== '') {
                    $default_not_show_arr = explode(',', $default_not_show);
                    if (in_array($current_category_id, $default_not_show_arr)) {
                        $default_show = 0;
                    }
                }
            }
            if(sizeof($products_narrow_value) <2 && !in_array($oID,$get_narrow_option)){

            }else {
                //限制对应指定分类下筛选项不展示
                $narrowShow = true;
                if (in_array($current_category_id, [3361,55])) {
                    if (in_array($oID, [58])) {
                        $narrowShow = false;
                    }
                }
                if ($narrowShow) {
                    //剔除该筛选项中被选中的值,判断此时的情况下,产品中对应的筛选项的值
                    $replace_option = array();
                    for ($ni = 0; $ni < sizeof($get_narrow); $ni++) {
                        if ($oID == $get_narrow_option[$ni]) { //当前筛选项下有筛选值选中时,替换
                        } else {
                            $replace_option [] = $get_narrow[$ni];
                        }
                    }

                    // 该分类下,先剔除当前筛选项,得到其他筛选后的产品,再从产品中判断该筛选项的值
                    if (sizeof($get_narrow)) {
                        $narrow_option_values = $this->zen_get_count_products_of_alnoe_narrow($replace_option, $oID, $current_category_id);
                    }
                    if (in_array($oID, $get_narrow_option) || $default_show) { //展开
                        $display_css_class = 'sidebar_06_js';
                        $display_dd_css_class = '';
                    } else {
                        $display_css_class = 'sidebarForJS';
                        $display_dd_css_class = 'display_none';
                    }

                    $css_type = $this->fs_narrow_by_opions_css_type($oID);   //筛选项样式
                    switch ($css_type) {
                        case '2':
                            $narrow_css = '';
                            break;
                        case '3':
                            $narrow_css = 'popularity_minWid258 popularity_width33_33';
                            break;
                        default:
                            $narrow_css = '';
                            break;
                    }
                    if ($type == 1) {
                        $Parent++;
                        $narrow_by_html .= '<dl class="popularity_view_listz1 new_proList_autoDev" sameparent="Parent' . $Parent . '">';
                        $narrow_by_html .= '<dt class="popularity_view_sortz1">
                                <p>' . $this->get_products_narrow_by_option_name($oID) . '<span class="iconfont icon">&#xf087;</span></p>
                                </dt><dd class="popularity_view_listz1_li '.$narrow_css.'"><div class="popularity_view_listArrow"></div><div class="popularity_view_listz1_liBox01">';
                    } else {
                        $Parent++;
                        $narrow_by_html .= '<dl class="m-list-dl right_hide_narrow">
                                            <dt>' . $this->get_products_narrow_by_option_name($oID) . ' <i class="iconfont icon">&#xf087;</i></dt>';
                        $narrow_by_html .='<div class="m-list-dd-div">';

                    }
                    $narrow_by_values = $this->fs_narrow_by_opions_values_by_oID_products($oID);   //分类产品筛选项下的筛选值
                    //筛选后的产品,拥有的筛选值.用来识别没有无结果的筛选值,隐藏
                    if (sizeof($narrow_by_values)) {
                        $narrow_by_values = $this->sort_order_narrow_by_values($narrow_by_values);     //筛选值排序
                        $nvi = 0;
                        $cDIV = false;
                        $hideNV = false;
                        foreach ($narrow_by_values as $ii => $vID) {
                            $is_current = $narrow_get_parmas_string = '';
                            //$page = FILENAME_NARROW;
                            $page = FILENAME_DEFAULT;
                            $except_values = array('cPath', 'narrow');
                            $new_narrow_by_array = array();
                            $href = $name = $count_of_narrow_by_products = '';
                            $class = '';
                            $active = '';
                            $div_icon = '<span class="m-Screening-radio iconfont icon">&#xf022;</span>';
                            if (zen_not_null($get_narrow)) {
                                if (in_array($vID, $get_narrow)) {  //已选择的筛选值,添加样式
                                    $is_current = 'choosez';
                                    $class = $is_current;
                                    $active = 'active';
                                    $div_icon = '<span class="m-Screening-radio iconfont icon">&#xf021;</span>';
                                }
                            } else {
                                $new_narrow_by_array = array();
                            }
                            $_GET['narrow'] = $new_narrow_by_array;

                            $name = $this->get_option_values_name($vID);
                            $narrow_url = '';
                            $replace_narrow = array();
                            //其他参数 : 排序,页数,标签
                            if (isset($_GET['sort_order']) && $_GET['sort_order']) $narrow_url .= '&sort_order=' . $_GET['sort_order'] . '';
                            if (isset($_GET['count']) && intval($_GET['count'])) $narrow_url .= '&count=' . $_GET['count'];
                            if (isset($_GET['settab'])) {
                                $narrow_url .= '&settab=' . $_GET['settab'];
                            }

                            //如果下一步选择的筛选值和已选择的筛选值属于同一个筛选项,那么新的URL 是将选择的筛选值替换已选择的筛选值
                            //var_dump($get_narrow);
                            for ($ni = 0; $ni < sizeof($get_narrow); $ni++) {
                                if ($vID == $get_narrow[$ni]) {    //取消已选择的筛选值
                                    if($type == 1){
                                        $narrow_url .= '';
                                    }else{
                                        $narrow_url .= '&narrow[]=' . $vID;
                                    }
                                } else if ($oID == $get_narrow_option[$ni]) { //当前筛选项下有筛选值选中时,替换
                                    $narrow_url .= '&narrow[]=' . $vID;
                                    //var_dump(222);
                                } else {
                                    $narrow_url .= '&narrow[]=' . $get_narrow[$ni];
                                    //var_dump(333);
                                }
                            }

                            if ($get_narrow_option) {
                                if (!in_array($oID, $get_narrow_option)) {        //没有勾选的筛选项
                                    if (!in_array($vID, $products_narrow_value)) {   //如果当前产品没有未勾选筛选项中的筛选值,则筛选值不显示
                                        $hideNV = true;
                                    } else {
                                        $hideNV = false;
                                        $nvi++;
                                    }
                                } else {   //同选中的筛选项,替换之后会有产品,才能显示
                                    //if(sizeof($get_narrow_option) > 1){
                                    //交叉筛选时,才用这个.两个及以上的筛选
                                    if (in_array($vID, $narrow_option_values)) {  //筛选条件下,是否有产品
                                        $hideNV = false;
                                        $nvi++;
                                    } else {
                                        $hideNV = true;
                                    }
                                    //}
                                }
                                //过滤该option下的vid  , 从产品中查询是否有该vID
                                if (!in_array($oID, $get_narrow_option)) {  //除去当前筛选,选择新的筛选值时,新增URL参数
                                    $narrow_url .= '&narrow[]=' . $vID;
                                }
                            } else {
                                if (!in_array($vID, $products_narrow_value)) {   //如果当前产品没有未勾选筛选项中的筛选值,则筛选值不显示
                                    $hideNV = true;
                                } else {
                                    $hideNV = false;
                                    $nvi++;
                                }
                                $narrow_url .= '&narrow[]=' . $vID;
                            }
                            //$narrow_item = $this->get_all_get_params($except_values,$trim);
                            $href = zen_href_link($page, $narrow_url . '&cPath=' . $current_category_id);
                            //var_dump($narrow_url);
                            if (!$hideNV) {
                                if (!in_array($vID,[21102, 24])) {
                                    //待下架的材质产品所属筛选项只在清仓展示
                                    if ($type == 1) {
                                        if ($class == '') {
                                            $narrow_by_html .= '<div class="popularity_view_listz1_liMain">
                                        <a href="' . $href . '"><div class="new_proList_mainLabel ' . $class . '" data-narrow="' . $vID . '" samedata="Had0">' . $name . '</div></a>
                                        </div>';
                                        } else {
                                            $narrow_by_html .= '<div class="popularity_view_listz1_liMain">
                                        <div class="new_proList_mainLabel ' . $class . '" data-narrow="' . $vID . '" samedata="Had0">' . $name . '</div>
                                        </div>';
                                        }
                                    } else {
                                        if ($class == '') {
                                            $narrow_by_html .= '<dd class="m_product_list_dd ' . $active . '" id="li_'.$vID.'" onclick="set_narrow_show(this,'.$vID.')">
                                                       '.$div_icon.'
                                                          <div data="' . $vID . '" samedata = "Had'.$Parent.'" data-link="'.$href.'">' . $name . '</div>
                                                        </dd>';
                                        } else {
                                            $narrow_by_html .= '<dd class="m_product_list_dd ' . $active . '" id="li_'.$vID.'" onclick="set_narrow_show(this,'.$vID.')">
                                                       '.$div_icon.'
                                                          <div data="' . $vID . '" samedata = "Had'.$Parent.'" data-link="'.$href.'">' . $name . '</div>
                                                        </dd>';
                                        }
                                    }
                                }
                            }
                        }
                    }
                    //var_dump($get_narrow);
                    if ($type == 1) {
                        $narrow_by_html .= '<div></dd></dl>';
                    } else {
                        $narrow_by_html .= '</div>';
                        $narrow_by_html .= '</dl>';
                    }//传值就只展示5个选项
                }
            }
        }//只有一个筛选值的 筛选项不显示

        //  end of narrow option foreach
        //光模块第三级分类不需要下面这段
        // if (5 < strlen(strip_tags($narrow_by_html)) ) {
        // 	$narrow_by_html = '<div class="">'.$narrow_by_html .'</div>	';
        // }
        return $narrow_by_html;
    }

    //针对产品清仓页单独的分类最新筛选项
    function fs_products_clearance_header_new_list($pids,$get_narrow,$params,$type){
        global $db;
        $narrow_by_hidding = false;
        //默认展开
        $display_css_class = 'sidebar_06_js';
        $display_dd_css_class = '';

        //当前已选择的筛选值代表的筛选项
//      if(is_array($get_narrow) && sizeof($get_narrow)){
//	       foreach ($get_narrow as $vn => $noID){
//	        $select_narrow_option_array [] = zen_get_narrow_by_option_id_of_values_id($noID);
//	       }
//      }

        $narrow_by_html = '';
        $category_options = $this->fs_category_products_narrow_option($pids,'narrow','');  //分类产品拥有的筛选项
        $nar = array();
        $narrow_by_options = $this->sort_order_narrow_by_options($category_options);  //筛选项排序
        //$narrow_by_options = $this->sort_order_narrow_by_options($category_options);  //筛选项排序
        $trim = true;
        //筛选项循环
        $get_narrow_option = array();
        if(sizeof($get_narrow)){
            for($ni = 0; $ni< sizeof($get_narrow);$ni++){
                $get_narrow_option [] = $this->fs_narrow_by_option_id_of_values_id($get_narrow[$ni]);
            }
        }
        $Parent = 1;
        foreach ($narrow_by_options as $i => $oID){
            $products_narrow_value  = $this->fs_narrow_by_values_by_select_products($oID,$pids);   //当前产品,当前筛选项下拥有的筛选值
            if(sizeof($products_narrow_value) <2 && !in_array($oID,$get_narrow_option)){

            }else {
                //剔除该筛选项中被选中的值,判断此时的情况下,产品中对应的筛选项的值
                $replace_option = array();
                for ($ni = 0; $ni < sizeof($get_narrow); $ni++) {
                    if ($oID == $get_narrow_option[$ni]) { //当前筛选项下有筛选值选中时,替换
                    } else {
                        $replace_option [] = $get_narrow[$ni];
                    }
                }

                // 该分类下,先剔除当前筛选项,得到其他筛选后的产品,再从产品中判断该筛选项的值
                if(sizeof($pids)){
                    $narrow_option_values = $this->fs_narrow_by_values_by_select_products($oID,$pids);
                }

                $css_type = $this->fs_narrow_by_opions_css_type($oID);   //筛选项样式
                switch ($css_type) {
                    case '2':
                        $narrow_css = '';
                        break;
                    case '3':
                        $narrow_css = 'popularity_minWid258 popularity_width33_33';
                        break;
                    default:
                        $narrow_css = '';
                        break;
                }
                if ($type == 1) {
                    $Parent++;
                    $narrow_by_html .= '<dl class="popularity_view_listz1 new_proList_autoDev" sameparent="Parent' . $Parent . '">';
                    $narrow_by_html .= '<dt class="popularity_view_sortz1">
                                <p>' . $this->get_products_narrow_by_option_name($oID) . '<span class="iconfont icon">&#xf087;</span></p>
                                </dt><dd class="popularity_view_listz1_li '.$narrow_css.'"><div class="popularity_view_listArrow"></div><div class="popularity_view_listz1_liBox01">';
                } else {
                    $Parent++;
                    $narrow_by_html .= '<li class="new_proList_seeSli_catLi right_hide_narrow">
                                    <div class="new_proList_seeSli_catMain" sameparent="Parent' . $Parent . '">';
                    $narrow_by_html .= '<span class="new_proList_seeSli_catxt">' . $this->get_products_narrow_by_option_name($oID) . '</span>
                                    <span class="iconfont icon">&#xf057;</span>
                                    </div>
                                    <div class="new_proList_seeSli_catMain1">
                                    <ul class="narrow_by_show_all">';

                }

                $narrow_by_values = $this->fs_narrow_by_opions_values_by_oID_products($oID);   //分类产品筛选项下的筛选值
                //var_dump($narrow_by_values);

                //筛选后的产品,拥有的筛选值.用来识别没有无结果的筛选值,隐藏

                if (sizeof($narrow_by_values)) {
                    $narrow_by_values = $this->sort_order_narrow_by_values($narrow_by_values);     //筛选值排序
                    $nvi = 0;
                    $cDIV = false;
                    $hideNV = false;
                    foreach ($narrow_by_values as $ii => $vID) {
                        $is_current = $narrow_get_parmas_string = '';
                        //$page = FILENAME_NARROW;
                        $page = FILENAME_DEFAULT;
                        $except_values = array('cPath', 'narrow');
                        $new_narrow_by_array = array();
                        $href = $name = $count_of_narrow_by_products = '';
                        $class = '';
                        if (zen_not_null($get_narrow)) {
                            if (in_array($vID, $get_narrow)) {  //已选择的筛选值,添加样式
                                $is_current = 'choosez';
                                $class = $is_current;
                            }
                        } else {
                            $new_narrow_by_array = array();
                        }
                        $_GET['narrow'] = $new_narrow_by_array;

                        $name = $this->get_option_values_name($vID);
                        $narrow_url = '';
                        //其他参数 : 排序,页数,标签
                        if(isset($_GET['sort_order']) && $_GET['sort_order']){
                            $narrow_url .= $params;
                        }else{
                            if (isset($_GET['type']) && intval($_GET['type'])) $narrow_url .= '&type=' . $_GET['type'];
                        }

                        //如果下一步选择的筛选值和已选择的筛选值属于同一个筛选项,那么新的URL 是将选择的筛选值替换已选择的筛选值
                        //var_dump($get_narrow);
                        for ($ni = 0; $ni < sizeof($get_narrow); $ni++) {
                            if ($vID == $get_narrow[$ni]) {    //取消已选择的筛选值
                                if($type == 1){
                                    $narrow_url .= '';
                                }else{
                                    $narrow_url .= '&narrow[]=' . $vID;
                                }
                            } else if ($oID == $get_narrow_option[$ni]) { //当前筛选项下有筛选值选中时,替换
                                $narrow_url .= '&narrow[]=' . $vID;
                                //var_dump(222);
                            } else {
                                $narrow_url .= '&narrow[]=' . $get_narrow[$ni];
                                //var_dump(333);
                            }
                        }

                        if ($get_narrow_option) {
                            if (!in_array($oID, $get_narrow_option)) {        //没有勾选的筛选项
                                if (!in_array($vID, $products_narrow_value)) {   //如果当前产品没有未勾选筛选项中的筛选值,则筛选值不显示
                                    $hideNV = true;
                                } else {
                                    $hideNV = false;
                                    $nvi++;
                                }
                            } else {   //同选中的筛选项,替换之后会有产品,才能显示
                                //if(sizeof($get_narrow_option) > 1){
                                //交叉筛选时,才用这个.两个及以上的筛选
                                if (in_array($vID, $narrow_option_values)) {  //筛选条件下,是否有产品
                                    $hideNV = false;
                                    $nvi++;
                                } else {
                                    $hideNV = true;
                                }
                                //}
                            }
                            //过滤该option下的vid  , 从产品中查询是否有该vID
                            if (!in_array($oID, $get_narrow_option)) {  //除去当前筛选,选择新的筛选值时,新增URL参数
                                $narrow_url .= '&narrow[]=' . $vID;
                            }
                        } else {
                            if (!in_array($vID, $products_narrow_value)) {   //如果当前产品没有未勾选筛选项中的筛选值,则筛选值不显示
                                $hideNV = true;
                            } else {
                                $hideNV = false;
                                $nvi++;
                            }
                            $narrow_url .= '&narrow[]=' . $vID;
                        }
                        //$narrow_item = $this->get_all_get_params($except_values,$trim);
                        $href = zen_href_link(FILENAME_CLEARANCE_LIST, $narrow_url);
                        //var_dump($narrow_url);
                        if (!$hideNV) {
                            if ($type == 1) {
                                if ($class == '') {
                                    $narrow_by_html .= '<div class="popularity_view_listz1_liMain">
                                        <a href="' . $href . '"><div class="new_proList_mainLabel ' . $class . '" data-narrow="' . $vID . '" samedata="Had0">' . $name . '</div></a>
                                        </div>';
                                } else {
                                    $narrow_by_html .= '<div class="popularity_view_listz1_liMain">
                                        <div class="new_proList_mainLabel ' . $class . '" data-narrow="' . $vID . '" samedata="Had0">' . $name . '</div>
                                        </div>';
                                }
                            } else {
                                if ($class == '') {
                                    $narrow_by_html .= '<li class="new_proList_seeSli_catLil ' . $class . '" id="li_'.$vID.'" onclick="set_narrow_show(this,'.$vID.',1)">
                                            <div data="' . $vID . '" samedata = "Had'.$Parent.'" data-link="'.$href.'">' . $name . '</div>
                                            </li>';
                                } else {
                                    $narrow_by_html .= '<li class="new_proList_seeSli_catLil ' . $class . '" id="li_'.$vID.'" onclick="set_narrow_show(this,'.$vID.',1)">
                                            <div data="' . $vID . '" samedata = "Had'.$Parent.'" data-link="'.$href.'">' . $name . '</div>
                                            </li>';
                                }
                            }
                        }
                    }
                }
                //var_dump($get_narrow);
                if ($type == 1) {
                    $narrow_by_html .= '<div></dd></dl>';
                } else {
                    $narrow_by_html .= '</ul></div></li>';
                }
            }//传值就只展示5个选项
        }//只有一个筛选值的 筛选项不显示

        //  end of narrow option foreach
        //光模块第三级分类不需要下面这段
        // if (5 < strlen(strip_tags($narrow_by_html)) ) {
        // 	$narrow_by_html = '<div class="">'.$narrow_by_html .'</div>	';
        // }
        return $narrow_by_html;
    }

    //分类产品拥有的筛选项
    function fs_category_products_narrow_option($pids,$page,$current_category_id){
      global $db;
      // 0 是通用,1是搜索专用,2是分类专用,3是搜索初始,4是搜索+二级
      
      if($page =='cpath'){
       $parentID=categories_of_parent_id($current_category_id) ; //如果是二级分类,需要调用
       $all_subcategories = zen_get_all_subcategories_of_cid(0);
       foreach($all_subcategories as $sub){
	    $all_subcategories_ids [] = $sub['id'];
       }
       if(in_array($parentID,$all_subcategories_ids)){
        $type_search = ' and narrow_type in(0,2,4,5) and is_category_show = 1';
       }else{
        $type_search = ' and narrow_type in(0,2)';
       }
      }else if($page =='narrow'){
      $type_search = ' and narrow_type in(0,1,3,4,5)'; 
      }
      $narrowoid = array();
      $narrow = $db->Execute("select nvtp.products_narrow_by_options_id FROM 
      ".TABLE_PRODUCTS_NARROW_BY_OPTION_VALUES_TO_PRODUCTS  ." as nvtp
      left join ".TABLE_PRODUCTS_NARROW_BY_OPTIONS  ." as pno on(nvtp.products_narrow_by_options_id = pno.products_narrow_by_options_id)
      where nvtp.products_id in(".join(',',$pids).")  ".$type_search."
      and language_id =".(int)$this->languages_id." 
      GROUP BY nvtp.products_narrow_by_options_id ");
      
      if ($narrow->RecordCount()){
			while (!$narrow->EOF){
			    if(($current_category_id == 1068 && $narrow->fields['products_narrow_by_options_id']==98) || ($current_category_id == 2961 && $narrow->fields['products_narrow_by_options_id']==162)){
                }else{
                    $narrowoid [] = $narrow->fields['products_narrow_by_options_id'];
                }
				$narrow->MoveNext();
			}
	  }
	  return $narrowoid;
    }
    
	function get_products_narrow_by_option_name($oID){
			global $db;
			$option_values = array();
			$result = $db->Execute("select products_narrow_by_options_name  as name 
				from " . TABLE_PRODUCTS_NARROW_BY_OPTIONS. " 
				where products_narrow_by_options_id = ".(int)$oID." and language_id =".(int)$this->languages_id."");
        $result->fields['name'] = swap_american_to_britain($result->fields['name']);
        global $cPath_array;
        return content_preg_mtp($result->fields['name'],$cPath_array[0]);
	}
    
    function fs_narrow_by_opions_css_type($oID){
	  global $db;
	  $result = $db->Execute("select css_type
				from " . TABLE_PRODUCTS_NARROW_BY_OPTIONS. " 
				where products_narrow_by_options_id = ".(int)$oID);
	  return $result->fields['css_type'];
	}
	
    //分类产品筛选项下的筛选值
    function fs_narrow_by_opions_values_by_oID_products($oID){
        global $db;
        $narrowvid = array();
        $narrow = $db->Execute("select products_narrow_by_options_values_id FROM 
      ".TABLE_PRODUCTS_NARROW_BY_OPTION_VALUES_TO_PRODUCTS  ."
      where products_narrow_by_options_id = '".(int)$oID."'
      GROUP BY products_narrow_by_options_values_id ");

        if ($narrow->RecordCount()){
            while (!$narrow->EOF){
                $narrowvid [] = $narrow->fields['products_narrow_by_options_values_id'];
                $narrow->MoveNext();
            }
        }
        return $narrowvid;
    }

    //筛选项排序
	function sort_order_narrow_by_options($narrow_by_options){
		global $db;
		$return = array();
		
		$sql_select = "SELECT products_narrow_by_options_id as id FROM products_narrow_by_options  ";
		
		$sql_where = " WHERE products_narrow_by_options_id  ";
		
		if (1 < sizeof($narrow_by_options)) {
			$sql_where .= " IN ( ".join(',',$narrow_by_options)." ) ";
		}else {
			$sql_where .=" = ".(int)$narrow_by_options[0];
		}
		
		$sql_order_by =" and language_id =".(int)$this->languages_id." ORDER BY products_narrow_by_options_sort_order,products_narrow_by_options_id ";
		
		$sql = $sql_select.$sql_where.$sql_order_by;
		
		$result = $db->Execute($sql);
		
		while (!$result->EOF) {
			
			$return [] = $result->fields['id'];
			$result->MoveNext();
		}		
		return $return;
	}
    
    //当前产品拥有的筛选值
    function fs_narrow_by_values_by_select_products($oid,$pids){
        global $db;
        $narrowoid = array();
        $sql ="select nvtp.products_narrow_by_options_values_id FROM 
      ".TABLE_PRODUCTS_NARROW_BY_OPTION_VALUES_TO_PRODUCTS  ." as nvtp
      where products_narrow_by_options_id = '".(int)$oid."' and products_id in(".join(',',$pids).")
      GROUP BY nvtp.products_narrow_by_options_values_id ";
        $narrow = $db->Execute($sql);
        if ($narrow->RecordCount()){
            while (!$narrow->EOF){
                $narrowoid [] = $narrow->fields['products_narrow_by_options_values_id'];
                $narrow->MoveNext();
            }
        }
        return $narrowoid;
    }

    //当前产品拥有的筛选值
    // 相比fs_narrow_by_values_by_select_products方法,进行了排序，也获取了name
    function fs_narrow_by_values_by_select_products_new($oid,$pids=''){
        global $db;
        $narrowoid = array();
        $where = '';
        if($pids){
            $where .= ' and nvtp.products_id in('.join(',',$pids).') ';
        }
        $sql ="select v.products_narrow_by_options_values_id,v.products_narrow_by_options_values_name 
        FROM ".TABLE_PRODUCTS_NARROW_BY_OPTION_VALUES_TO_PRODUCTS  ." as nvtp
        left join ".TABLE_PRODUCTS_NARROW_BY_OPTIONS_VALUES  ." as v on v.products_narrow_by_options_values_id=nvtp.products_narrow_by_options_values_id
        where 1 and nvtp.products_narrow_by_options_id =".(int)$oid.$where." and v.language_id=".$this->languages_id."
        GROUP BY nvtp.products_narrow_by_options_values_id 
        ORDER BY v.products_narrow_by_options_values_sort_order,v.products_narrow_by_options_values_id";
        $narrow = $db->Execute($sql);
        if ($narrow->RecordCount()){
            while (!$narrow->EOF){
                $narrowoid [] = array(
                    'id' => $narrow->fields['products_narrow_by_options_values_id'],
                    'name' => $narrow->fields['products_narrow_by_options_values_name'],
                );
                $narrow->MoveNext();
            }
        }
        return $narrowoid;
    }
    
	function get_option_values_name($values_id){
		global $db;
		$result = $db->Execute("select products_narrow_by_options_values_name  as value
			from " . TABLE_PRODUCTS_NARROW_BY_OPTIONS_VALUES. "  
			where products_narrow_by_options_values_id = ".(int)$values_id." and language_id = ".$this->languages_id." ");
		if(in_array($_SESSION['languages_code'],array('uk','au','dn'))){
            $result->fields['value'] = swap_american_to_britain($result->fields['value']);
        }
		global $cPath_array;
		return content_preg_mtp($result->fields['value'],$cPath_array[0]);
	}
    
    //筛选值排序
	function sort_order_narrow_by_values($narrow_by_values){
		global $db;
		$return = array();
		$sql_select = "SELECT DISTINCT products_narrow_by_options_values_id as id FROM " . TABLE_PRODUCTS_NARROW_BY_OPTIONS_VALUES. "  ";
		$sql_where = " WHERE products_narrow_by_options_values_id  ";
		if (1 < sizeof($narrow_by_values)) {
			$sql_where .= " IN ( ".join(',',$narrow_by_values)." ) ";
		}else {
			$sql_where .=" = ".(int)$narrow_by_values[0];
		}
		$sql_order_by =" and language_id =".(int)$this->languages_id." ORDER BY products_narrow_by_options_values_sort_order,products_narrow_by_options_values_id ";
		$sql = $sql_select.$sql_where.$sql_order_by;
		$result = $db->Execute($sql);
		while (!$result->EOF) {
			$return [] = $result->fields['id'];
			$result->MoveNext();
		}		
		return $return;
	}

    function fs_narrow_by_option_id_of_values_id($vid){
    global $db;
    $narrow = $db->Execute("select products_narrow_by_options_id from " . TABLE_PRODUCTS_NARROW_BY_OPTIONS_VALUES. " 
    where products_narrow_by_options_values_id=".(int)$vid." and language_id = ".$this->languages_id."");
    return $narrow->fields['products_narrow_by_options_id'];
    }

	
	// 该分类下,先剔除当前筛选项,得到其他筛选后的产品,再从产品中判断该筛选项的值
	function zen_get_count_products_of_alnoe_narrow($products_narrow_by_option_values_ids,$oid,$current_category_id){
	 global $db;
	$return = array();
	$narrow_by_count = sizeof($products_narrow_by_option_values_ids);
	if (zen_has_category_subcategories($current_category_id)) {
	$all_subcategories_ids = array();
	zen_get_subcategories_redis($all_subcategories_ids,$current_category_id);
        $all_subcategories_ids[] = $current_category_id; //CPBUG202104013 加上当前分类ID  主要解决当前分类有子分类 且当前分类也绑定了产品和筛选项 排除掉了 筛选项不展示的情况
	
	$count_of_subcategories = sizeof($all_subcategories_ids);
	if ($count_of_subcategories){
		
		if (1 < $count_of_subcategories) {
			
			$category_where_sql = " AND ptc.categories_id in(".join(',',$all_subcategories_ids).")";
		}else if (1 == $count_of_subcategories) {
			$category_where_sql = " AND ptc.categories_id = ".$all_subcategories_ids[0];
		}
	}else {
			$category_where_sql = " AND ptc.categories_id = ".(int)$current_category_id;
	}
    }else {
  		$category_where_sql = " AND ptc.categories_id = ".(int)$current_category_id;
  	}  
	$query_select_colums = " select p.products_id";
	$warehouse_data = fs_products_warehouse_where();
	$warehouse_where = $warehouse_data['where'] ? $warehouse_data['where'] : '';
	$inquiry_field = 'is_'.$warehouse_data['code'].'_inquiry';
    $query_where = " WHERE p.products_status = 1 and p.is_important!=10 and (p.products_price >0 || ".$inquiry_field." =1) AND ptc.is_show=1 ".$warehouse_where;
	$from_narrow_by='';
	if (zen_not_null($products_narrow_by_option_values_ids)){
		if (1 == $narrow_by_count) {
	        $from_narrow_by =" left join ".TABLE_PRODUCTS_NARROW_BY_OPTION_VALUES_TO_PRODUCTS ." as povp on p.products_id = povp.products_id";
	        $and_narrow_by = " and povp.products_narrow_by_options_values_id = ".(int)$products_narrow_by_option_values_ids[0];
		}else {
		    $from_narrow_by='';
			$where_narrow_by = ' select t0.products_id from ';
			$sql_query_array = array();
			for($i = 0; $i< $narrow_by_count;$i++){
				$sql_query_array[] = " (select products_id from  ".TABLE_PRODUCTS_NARROW_BY_OPTION_VALUES_TO_PRODUCTS . "
						where products_narrow_by_options_values_id = ".(int)$products_narrow_by_option_values_ids[$i] ."
								      ) as t".$i ." ";
			}
			for($i = 0,$n=sizeof($sql_query_array); $i< $n;$i++){
				if($i){
					$where_narrow_by .=' CROSS JOIN';
				}
					$where_narrow_by .= $sql_query_array[$i];
				if($i){
					$where_narrow_by .= " ON t".($i-1).".products_id = t".$i.".products_id ";
				}
			}
			$and_narrow_by =  " AND p.products_id in(".$where_narrow_by.")";
		}
	}
	$query_from = " FROM ". TABLE_PRODUCTS . " AS p 
				LEFT JOIN " . TABLE_PRODUCTS_TO_CATEGORIES . " AS ptc on p.products_id = ptc.products_id 
				".$from_narrow_by."
				";
    $listing_sql = $query_select_colums . $query_from .$query_where. $category_where_sql.$and_narrow_by.$sql_order_by;
	//	print_r($listing_sql);
	$get_products = $db->Execute($listing_sql);
	 $products = array();
	 if ($get_products->RecordCount()){
		while (!$get_products->EOF){
			$products [] =  $get_products->fields['products_id'];
			$get_products->MoveNext();
		}
	 }
    
	 //满足筛选后的产品.求某特定筛选项的值
	 $products_narrow_values = array();
	 if(sizeof($products)){
	   $products_narrow_values = $this->fs_narrow_by_values_by_select_products($oid,$products);
	 }
	 return $products_narrow_values;
	}
	
	//finder 分类标签页面筛选
	function zen_get_count_products_of_finder_narrow($products_narrow_by_option_values_ids,$oid,$current_category_id){
	  global $db;
     $narrow_by_count = sizeof($products_narrow_by_option_values_ids);
	$from_narrow_by='';
	if (zen_not_null($products_narrow_by_option_values_ids)){
		if (1 == $narrow_by_count) {
	        $from_narrow_by =" left join ".TABLE_PRODUCTS_NARROW_BY_OPTION_VALUES_TO_PRODUCTS ." as povp using(products_id)";
	        $and_narrow_by = " and povp.products_narrow_by_options_values_id = ".(int)$products_narrow_by_option_values_ids[0];
		}else {
		    $from_narrow_by='';
			$where_narrow_by = ' select t0.products_id from ';
			$sql_query_array = array();
			for($i = 0; $i< $narrow_by_count;$i++){
				$sql_query_array[] = " (select products_id from  ".TABLE_PRODUCTS_NARROW_BY_OPTION_VALUES_TO_PRODUCTS . "
						where products_narrow_by_options_values_id = ".(int)$products_narrow_by_option_values_ids[$i] ."
								      ) as t".$i ." ";
			}
			for($i = 0,$n=sizeof($sql_query_array); $i< $n;$i++){
				if($i){
					$where_narrow_by .=' CROSS JOIN';
				}
					$where_narrow_by .= $sql_query_array[$i];
				if($i){
					$where_narrow_by .= " ON t".($i-1).".products_id = t".$i.".products_id ";
				}
			}
			$and_narrow_by =  " AND p.products_id in(".$where_narrow_by.")";
		}
	}
    $SQLwhere = "where tag_categories_id = ".(int)$current_category_id;
    $listing_sql = "select p.products_id from meta_tags_of_search_categories_products as p ".$from_narrow_by.$SQLwhere.$and_narrow_by;
	$get_products = $db->Execute($listing_sql);
	 $products = array();
	 if ($get_products->RecordCount()){
		while (!$get_products->EOF){
			$products [] =  $get_products->fields['products_id'];
			$get_products->MoveNext();
		}
	 }
    
	 //满足筛选后的产品.求某特定筛选项的值
	 $products_narrow_values = array();
	 if(sizeof($products)){
	   $products_narrow_values = $this->fs_narrow_by_values_by_select_products($oid,$products);
	 }
	 return $products_narrow_values;
}
	
	//搜索页面默认筛选项
	function  fs_search_products_narrow_option($pids){
	  global $db;
	  if($pids && sizeof($pids)){
      $narrowoid = array();
      $narrow = $db->Execute("select nvtp.products_narrow_by_options_id FROM 
      ".TABLE_PRODUCTS_NARROW_BY_OPTION_VALUES_TO_PRODUCTS  ." as nvtp
      left join ".TABLE_PRODUCTS_NARROW_BY_OPTIONS  ." as pno on(nvtp.products_narrow_by_options_id = pno.products_narrow_by_options_id)
      where nvtp.products_id in(".join(',',$pids).")  and narrow_type in(0,3) and language_id = ".$this->languages_id."
      ");
      
      if ($narrow->RecordCount()){
			while (!$narrow->EOF){
				$narrowoid [] = $narrow->fields['products_narrow_by_options_id'];
				$narrow->MoveNext();
			}
	  }
	  return $narrowoid;
	  }
	}

    // 获取一定narrow_type的筛选项
    // 相比 fs_search_products_narrow_option、fs_category_products_narrow_option。增加了去重、排序、一些需要字段
	function  fs_search_products_narrow_option_new($pids,$page='',$current_category_id=0,$narrow_name=''){
		// 0 是通用,1是搜索专用,2是分类专用,3是搜索初始,4搜索+二级
		global $db;
		if($pids && sizeof($pids)){
			$narrowoid = array();
			$where = '';

			if($page =='cpath'){
				$parentID=categories_of_parent_id($current_category_id) ; //如果是二级分类,需要调用
				$all_subcategories = zen_get_all_subcategories_of_cid(0);
				foreach($all_subcategories as $sub){
					$all_subcategories_ids [] = $sub['id'];
				}
				if(in_array($parentID,$all_subcategories_ids)){
					$where .= ' and pno.narrow_type in(0,2,4,5) ';
				}else{
					$where .= ' and pno.narrow_type in(0,2) ';
				}
			}else if($page =='narrow'){
				$where .= ' and pno.narrow_type in(0,1,3,4,5) ';
			}else{
				$where .= ' and pno.narrow_type in(0,3) ';
			}
			$limit = '';
			if($narrow_name){
				$where .= ' and pno.products_narrow_by_options_name="'.$narrow_name.'" ';
				$limit = ' limit 1 ';
			}

			$order = ' ORDER BY pno.products_narrow_by_options_sort_order,pno.products_narrow_by_options_id ';

			$narrow = $db->Execute("select DISTINCT pno.products_narrow_by_options_id,pno.narrow_type,pno.css_type,pno.products_narrow_by_options_name,pno.default_not_show
            FROM ".TABLE_PRODUCTS_NARROW_BY_OPTION_VALUES_TO_PRODUCTS  ." as nvtp
            left join ".TABLE_PRODUCTS_NARROW_BY_OPTIONS  ." as pno on(nvtp.products_narrow_by_options_id = pno.products_narrow_by_options_id and pno.language_id = ".$this->languages_id.")
            where nvtp.products_id in(".join(',',$pids).")".$where.$order.$limit);

			if ($narrow->RecordCount()){
				while (!$narrow->EOF){
					$narrowoid [] = array(
							'id' =>$narrow->fields['products_narrow_by_options_id'],
							'narrow_type' =>$narrow->fields['narrow_type'],
							'narrow_name' =>$narrow->fields['products_narrow_by_options_name'],
							'css_type' =>$narrow->fields['css_type'],
							'default_not_show' =>$narrow->fields['default_not_show'],
					);
					$narrow->MoveNext();
				}
			}
			return $narrowoid;
		}
	}
	
	//搜索页面的筛选项列表
    function fs_search_products_narrow_by_list($pids,$get_narrow,$keyword,$words,$key_array,$page = FILENAME_ADVANCED_SEARCH_RESULT,$params=''){
      global $cPath_array;
	  $narrow_by_hidding = false;
      //当前已选择的筛选值代表的筛选项
      if(is_array($get_narrow) && sizeof($get_narrow)){
	       foreach ($get_narrow as $vn => $noID){
	        $select_narrow_option_array [] = zen_get_narrow_by_option_id_of_values_id($noID);
	       }
	     $category_options = $this->fs_category_products_narrow_option($pids,'narrow','');  //分类产品拥有的筛选项
	     $display_css_class = 'sidebarForJS';
 	     //$display_dd_css_class = 'display_none';
      }else{
         $narrow_by_hidding = true;
         $category_options = $this->fs_search_products_narrow_option($pids);  //搜索页面默认筛选项
         $display_css_class = 'sidebar_06_js';
 	     $display_dd_css_class = '';
      }

      $narrow_by_html = '';
	  $narrow_by_options = $this->sort_order_narrow_by_options($category_options);  //筛选项排序
	  $trim = true;
	  //筛选项循环
      $get_narrow_option = array();
      if(sizeof($get_narrow)){
          for($ni = 0; $ni< sizeof($get_narrow);$ni++){
			      $get_narrow_option [] = $this->fs_narrow_by_option_id_of_values_id($get_narrow[$ni]);
	      }
      }
      $css_type='';$narrow_css='';
	  foreach ($narrow_by_options as $i => $oID){	
	    $narrow_type = fs_get_data_from_db_fields('narrow_type','products_narrow_by_options','products_narrow_by_options_id='.$oID,''); 
		$products_narrow_value  = $this->fs_narrow_by_values_by_select_products($oID,$pids);   //当前产品,当前筛选项下拥有的筛选值


	    //剔除该筛选项中被选中的值,判断此时的情况下,产品中对应的筛选项的值
	    $replace_option = array();
	  	for($no = 0; $no< sizeof($get_narrow);$no++){
			    if($oID == $get_narrow_option[$no]){ //当前筛选项下有筛选值选中时,替换
				}else{
				   	$replace_option [] = $get_narrow[$no];
				}
		}
		$narrow_option_values = $this->zen_get_count_products_of_serach_narrow($replace_option,$oID,$keyword,$words,$key_array);
		//只有一个筛选值,并且不是默认筛选项时,不显示
	    if(sizeof($narrow_option_values) <2 && $narrow_type != 3){
	    }else{
        
		//end 该筛选项在产品中的赋值
	    
	  	 if(in_array($oID,$get_narrow_option) || $narrow_by_hidding){
	       $display_css_class = 'sidebar_06_js';
 	       $display_dd_css_class = '';
	     }else{
	       $display_css_class = 'sidebarForJS';
	       //$display_dd_css_class = 'display_none';
	     }
	     
	     $css_type = $this->fs_narrow_by_opions_css_type($oID);   //筛选项样式
		 switch ($css_type){
		 case '2':
		 $narrow_css  ='two_column';
		 break;
		 case '3':
		 $narrow_css  ='three_column';
		 break;
		 default:
		 $narrow_css  ='';
		 break;
		 }
	     
	     $narrow_by_html .= '<dl class="select '.$narrow_css.'"> ';

			if(!is_numeric($keyword)){
				$narrow_by_html .= '<dt>
		                     <a class="'.$display_css_class.'" href="javascript:;">'.$this->get_products_narrow_by_option_name($oID).'</a>
		                    </dt>';}else{
				$narrow_by_html .= '<dt>
		                     <a class="'.$display_css_class.'" href="javascript:;">'.BOX_HEADING_CATEGORIES.'</a>
		                    </dt>';
				$categories_pid = zen_get_subcategories_of_one_category_ids($keyword);

				if(!empty($categories_pid)){
					$categories_id = zen_get_subcategories_of_one_category($categories_pid[1]);
					foreach ($categories_id as $z => $cID) {
						if($cID==$categories_pid[0]){
							$class_category = "xiand ";
						}else{
							$class_category = "";
						}

						$href = zen_href_link(FILENAME_DEFAULT, 'cPath=' . $cID);
						$narrow_by_html .= '<dd class="'.$class_category.'"><a  href="' . $href . '">' . zen_get_categories_name($cID) . '</a></dd>';
					}
				}

			}

		$narrow_by_values = $this->fs_narrow_by_opions_values_by_oID_products($oID);   //分类产品筛选项下的筛选值
		//筛选后的产品,拥有的筛选值.用来识别没有无结果的筛选值,隐藏
		
		if(sizeof($products_narrow_value)){
		$narrow_by_values = $this->sort_order_narrow_by_values($narrow_by_values);     //筛选值排序
		$nvi = 0;$cDIV = false;
		foreach ($narrow_by_values as $ii => $vID){

		$hideNV=false;
   			$is_current= $narrow_get_parmas_string = '';
   			//$page = FILENAME_NARROW;			
			$except_values = array('cPath','narrow');
			$new_narrow_by_array = array();
			$href =$name=$count_of_narrow_by_products= '';
			$class='';
			if (zen_not_null($get_narrow)) {
				if (in_array($vID,$get_narrow)) {  //已选择的筛选值,添加样式
					$is_current = 'xiand';
					$class = $is_current;
				}							
			}
			else {
				$new_narrow_by_array = array();
			}
			$_GET['narrow']= $new_narrow_by_array;

			//var_dump($get_narrow);
			$narrow_url = '';
			$replace_narrow = array();
			
			//如果下一步选择的筛选值和已选择的筛选值属于同一个筛选项,那么新的URL 是将选择的筛选值替换已选择的筛选值
			for($ni = 0; $ni< sizeof($get_narrow);$ni++){
			    if($vID == $get_narrow[$ni]){                                                   //取消已选择的筛选值
			        $narrow_url .='';
			    }else if($oID == $get_narrow_option[$ni]){ //当前筛选项下有筛选值选中时,替换
			        $replace_narrow [] = $vID;
					$narrow_url .='&narrow[]='.$vID;
				}else{
				   	$replace_narrow [] = $get_narrow[$ni];
					$narrow_url .='&narrow[]='.$get_narrow[$ni];
					
				}
			}
			if($get_narrow_option){
			    if(!in_array($oID,$get_narrow_option)){        //没有勾选的筛选项
				 if(!in_array($vID,$products_narrow_value)){   //如果当前产品没有未勾选筛选项中的筛选值,则筛选值不显示
				 $hideNV = true;
				 }else{
				 $hideNV = false;
				 $nvi ++;
				 }  
			    }else{                                         //同选中的筛选项,替换之后会有产品,才能显示
				   //if(sizeof($get_narrow_option) > 1){
                     //交叉筛选时,才用这个.两个及以上的筛选
				     if(in_array($vID,$narrow_option_values)){  //筛选条件下,是否有产品
				     $hideNV = false;
				     $nvi ++;
				     }else{
				     $hideNV = true;
				     }
 			      //}
			   }
			//过滤该option下的vid  , 从产品中查询是否有该vID
			if(!in_array($oID,$get_narrow_option)){  //除去当前筛选,选择新的筛选值时,新增URL参数
			  $narrow_url .='&narrow[]='.$vID;
			}
			}else{
				 if(!in_array($vID,$products_narrow_value)){   //如果当前产品没有未勾选筛选项中的筛选值,则筛选值不显示
				 $hideNV = true;
				 }else{
				 $hideNV = false;
				 $nvi ++;
				 }
			$narrow_url .='&narrow[]='.$vID;
			}
		  //$narrow_item = $this->get_all_get_params($except_values,$trim);
        
          $href= zen_href_link($page,$narrow_url.'&keyword='.$keyword.$params);
		    if(!$hideNV){
		    $name = $this->get_option_values_name($vID);
		        /*
		        if($nvi == 15){
				$cDIV = true;
			    $narrow_by_html .= '<div class="all_subcategories_list" id="narrow_pulldown" style="display:none;">';
				}
				*/
		        $narrow_by_html .= '<dd class="' .$class. ' '.$display_dd_css_class.'" '.'> ';
		        $narrow_by_html .= '<a href="'.$href.'">'.$name.'</a> ';
				$narrow_by_html .= '</dd>';
		    }	
		  }  
		  //  end of narrow values foreach
	     } 
	      /*
          if($cDIV){
		   $narrow_by_html .= '</div>';
           $narrow_by_html .= '<div id="pulldown_narrow" class="sidebar_more"><a id="pulldownNV" href="javascript:void(0);">Show More</a></div>';
          }
          */
         $narrow_by_html .= '</dl>';
	   } 
	  }
	  //  end of narrow option foreach
	  return $narrow_by_html;		
    }

	//搜索页面的筛选项列表
	function fs_search_products_narrow_by_list_new($pids,$get_narrow,$keyword,$words,$key_array,$search_type='old',$page = FILENAME_ADVANCED_SEARCH_RESULT,$params=''){
		$narrow_by_html = '';
		// 如果是搜索产品id

        $narrow_by_html .= '<div class="m-list-Screening-center" id="products_slide">
        <div class="m-list-dd-div">';
		if(is_numeric($keyword) && strlen($keyword) >= 5){
			$narrow_by_html .= '<dl class="m-list-dl right_hide_narrow">';
			$narrow_by_html .= '<dt>'.BOX_HEADING_CATEGORIES.'<i class="iconfont icon"></i></dt>';
			$categories_pid = zen_get_subcategories_of_one_category_ids($keyword);
			if(!empty($categories_pid)){
                $where_clearing = ' and is_clearing = 0 ';
				$categories_id = zen_get_subcategories_of_one_category($categories_pid[1],$where_clearing);
				foreach ($categories_id as $z => $cID) {
					if($cID==$categories_pid[0]){
						$href = zen_href_link(FILENAME_DEFAULT, 'cPath=' . $cID);
						$narrow_by_html .= '<dd class="m_product_list_dd" id="li_'.$cID.'"  style="display: none;">
                                                     <span class="m-Screening-radio iconfont icon"></span>
                                                     <div data-link="' . $href . '" samedata="Had1">'.zen_get_categories_name($cID).'</div>
                                                 </dd>';
					}
				}
			}
			$narrow_by_html .= '</dl></div></div>';
			return $narrow_by_html;
		}

		//当前产品组的 所有的筛选项
		if(is_array($get_narrow) && sizeof($get_narrow)){
			$narrow_by_options = $this->fs_search_products_narrow_option_new($pids,'narrow','');  //类型为narrow的筛选项,已去重,已排序
		}else{
			// 第一次搜索关键字
			$narrow_by_options = $this->fs_search_products_narrow_option_new($pids,'','',BOX_HEADING_CATEGORIES);  //默认的筛选项,已去重,已排序
			$narrow_by_options = $narrow_by_options[0];
			$oID = $narrow_by_options['id']; //筛选项ID
			$narrow_name = $narrow_by_options['narrow_name'];   //筛选项名称

			$dd_display_str = '';
			$products_narrow_value  = $this->fs_narrow_by_values_by_select_products_new($oID,$pids);   //筛选项、搜索出来的的产品，拥有的筛选值
			$narrow_by_values = $products_narrow_value; //循环的是：右侧筛选出来的产品、当前筛选项的筛选值。不需要判断是否显示隐藏，全部显示
			if(sizeof($products_narrow_value)){
                $narrow_by_html .= '<dl class="m-list-dl right_hide_narrow">';
                $narrow_by_html .= '<dt>'.$narrow_name.'<i class="iconfont icon"></i></dt>';
				// 筛选值循环start
				foreach ($narrow_by_values as $ii => $narrow_by_values_val){
					$vID = $narrow_by_values_val['id'];
					$name = $narrow_by_values_val['name'];
					$list_not_alink_class='';
					if (zen_not_null($get_narrow)) {
						if (in_array($vID,$get_narrow)) {  //已选择的筛选值,添加样式
							$list_not_alink_class = 'list_not_alink';
						}
					}
					// 获取当前筛选值的链接
					$narrow_url = '';
					//如果不存在选中的筛选项。比较简单
					$narrow_url .='&narrow[]='.$vID;
					$href= zen_href_link($page,$narrow_url.'&keyword='.$keyword.$params);

                    $narrow_by_html .= '<dd class="m_product_list_dd" id="li_'.$vID.'"  style="display: none;">
                                                 <span class="m-Screening-radio iconfont icon"></span>
                                                 <div data-link="' . $href . '" samedata="Had1">'.$name.'</div>
                                             </dd>';
				}
				// 筛选值循环 end
                $narrow_by_html .= '</dl></div></div>';
			}

			return $narrow_by_html;
		}

		// 获取已经选中的筛选项
		$get_narrow_option = array();
		if(sizeof($get_narrow)){
			for($ni = 0; $ni< sizeof($get_narrow);$ni++){
				$get_narrow_option [] = $this->fs_narrow_by_option_id_of_values_id($get_narrow[$ni]);
			}
		}

		//筛选项循环start
		foreach ($narrow_by_options as $i => $narrow_by_options_val){
			$oID = $narrow_by_options_val['id']; //筛选项ID
			$css_type = $narrow_by_options_val['css_type'];   //筛选项样式
			$narrow_name = $narrow_by_options_val['narrow_name'];   //筛选项名称
			$narrow_type = $narrow_by_options_val['narrow_type'];   //筛选项名称
			// 是否默认展示
			$default_show = 1;
			if($narrow_by_options_val['default_not_show'] !== ''){
				$default_not_show_arr = explode(',', $narrow_by_options_val['default_not_show']);
				if(in_array(0,$default_not_show_arr)) {
					$default_show = 0;
				}
			}

			$products_narrow_value  = $this->fs_narrow_by_values_by_select_products_new($oID,$pids);   //筛选项、搜索出来的的产品，拥有的筛选值

			if(!$get_narrow || ($get_narrow && !in_array($oID,$get_narrow_option) )){ // 没有选中筛选项 或者 当前的筛选项下面没有选中
				$products_narrow_value_count = count($products_narrow_value);
				if($narrow_type != 3 && $products_narrow_value_count < 2){ //如果只有一个筛选值,则不显示
					continue;
				}
				$narrow_by_values = $products_narrow_value; //循环的是：右侧筛选出来的产品、当前筛选项的筛选值。不需要判断是否显示隐藏，全部显示
			}else{ // 有选中筛选项，当前的筛选项下面有选中
				//剔除该筛选项中被选中的值,判断此时的情况下,产品中对应的筛选项的值
				$replace_option = array();
				for($no = 0; $no< sizeof($get_narrow);$no++){
					if($oID == $get_narrow_option[$no]){ //当前筛选项下有筛选值选中时,替换
					}else{
						$replace_option [] = $get_narrow[$no];
					}
				}

				if($search_type == 'old'){ //用原来的搜索
					$all_search_product = get_old_search_all_products($keyword,$words,$key_array,$replace_option);
				}else{
					$all_search_product = get_amazon_search_all_products($keyword,$replace_option);
				}
				$narrow_option_values = array();
				if(sizeof($all_search_product)){
					$narrow_option_values = $this->fs_narrow_by_values_by_select_products($oID,$all_search_product);
				}

				//只有一个筛选值,并且不是默认筛选项时,不显示
				if(sizeof($narrow_option_values) <2 && $narrow_type != 3){
					continue;
				}else{
					$narrow_by_values = $this->fs_narrow_by_values_by_select_products_new($oID);   //分类产品筛选项下的筛选值
				}
			}

			if(in_array($oID,$get_narrow_option) || $default_show){ //展开
				$display_css_class = 'sidebar_06_js';
				$dd_display_str = '';
			}else{
				$display_css_class = 'sidebarForJS';
				$dd_display_str = 'style="display:none;"  ';
			}
			switch ($css_type){
				case '2':
					$narrow_css  ='two_column';
					break;
				case '3':
					$narrow_css  ='three_column';
					break;
				default:
					$narrow_css  ='';
					break;
			}
			if(!is_numeric($keyword)){
                $narrow_by_html .= '<dl class="m-list-dl right_hide_narrow">';
                $narrow_by_html .= '<dt>'.$narrow_name.'<i class="iconfont icon"></i></dt>';
				if(sizeof($products_narrow_value)){
					// 筛选值循环start
					foreach ($narrow_by_values as $ii => $narrow_by_values_val){
						$hideNV = false;
						$vID = $narrow_by_values_val['id'];
						$name = $narrow_by_values_val['name'];
						$list_not_alink='&#xf022;';
						$class='';
						if (zen_not_null($get_narrow)) {
							if (in_array($vID,$get_narrow)) {  //已选择的筛选值,添加样式
								$class = ' active';
								$list_not_alink = '&#xf021;';
							}
						}

						// 获取当前筛选值的链接
						$narrow_url = '';
						if($get_narrow){
							// 对当前的网址（也就是当前选中的筛选项值）进行处理。
							for($ni = 0; $ni< sizeof($get_narrow);$ni++){
								if($vID == $get_narrow[$ni]){ //取消已选择的筛选值（已经选中，再次点击取消）
									$narrow_url .='';
								}else if($oID == $get_narrow_option[$ni]){ // 当前筛选值 和选中筛选值 在同一个筛选项下面，进行替换
									$narrow_url .='&narrow[]='.$vID;
								}else{ //都不是，保留原来已经选中的的筛选值
									$narrow_url .='&narrow[]='.$get_narrow[$ni];
								}
							}
							//除去当前筛选,选择新的筛选值时,新增URL参数
							if(!in_array($oID,$get_narrow_option)){
								$narrow_url .='&narrow[]='.$vID;
							}
						}else{ //如果不存在选中的筛选项。比较简单
							$narrow_url .='&narrow[]='.$vID;
						}
						if($get_narrow){
							if(in_array($oID,$get_narrow_option)){//筛选项下面有选中的时候
								if(!in_array($vID,$narrow_option_values)){  //该筛选值条件，没有产品不显示
									$hideNV = true;
								}
							}
						}
						if(!$hideNV){
							if($narrow_name == BOX_HEADING_CATEGORIES){
								$listLi_class = "listLi1 ".$list_not_alink;
							}else{
								$listLi_class = "listLi ".$class;
							}
							$href= zen_href_link($page,$narrow_url.'&keyword='.$keyword.$params);
                            $narrow_by_html .= '<dd class="m_product_list_dd'.$class.'" id="li_'.$vID.'" style="display: none;">
                                                         <span class="m-Screening-radio iconfont icon">'.$list_not_alink.'</span>
                                                         <div data-link="' . $href . '" samedata="Had1">'.$name.'</div>
                                                     </dd>
                                                 ';
						}
					}
					// 筛选值循环 end
				}
                $narrow_by_html .= '</dl>';
			}
		}
        $narrow_by_html .= '</div></div>';
		//  筛选项循环 end
		return $narrow_by_html;
	}

    //搜索页面分类链接
	function fs_search_products_narrow_by_href($pids,$get_narrow,$keyword,$words,$key_array,$page = FILENAME_ADVANCED_SEARCH_RESULT,$params=''){
		global $cPath_array;
		$narrow_by_hidding = false;

		//当前已选择的筛选值代表的筛选项
		if(is_array($get_narrow) && sizeof($get_narrow)){
			foreach ($get_narrow as $vn => $noID){
				$select_narrow_option_array [] = zen_get_narrow_by_option_id_of_values_id($noID);
			}
			$category_options = $this->fs_category_products_narrow_option($pids,'narrow','');  //分类产品拥有的筛选项
			$display_css_class = 'sidebarForJS';
			//$display_dd_css_class = 'display_none';
		}else{
			$narrow_by_hidding = true;
			$category_options = $this->fs_search_products_narrow_option($pids);  //搜索页面默认筛选项
			$display_css_class = 'sidebar_06_js';
			$display_dd_css_class = '';
		}
		$number=0;
		$narrow_by_html = '';
		$narrow_by_options = $this->sort_order_narrow_by_options($category_options);  //筛选项排序
		$trim = true;
		//筛选项循环

		$get_narrow_option = array();
		if(sizeof($get_narrow)){
			for($ni = 0; $ni< sizeof($get_narrow);$ni++){
				$get_narrow_option [] = $this->fs_narrow_by_option_id_of_values_id($get_narrow[$ni]);
			}
		}
		$css_type='';$narrow_css='';
		foreach ($narrow_by_options as $i => $oID){
			$narrow_type = fs_get_data_from_db_fields('narrow_type','products_narrow_by_options','products_narrow_by_options_id='.$oID,'');
			$products_narrow_value  = $this->fs_narrow_by_values_by_select_products($oID,$pids);   //当前产品,当前筛选项下拥有的筛选值

			//剔除该筛选项中被选中的值,判断此时的情况下,产品中对应的筛选项的值
			$replace_option = array();
			for($no = 0; $no< sizeof($get_narrow);$no++){
				if($oID == $get_narrow_option[$no]){ //当前筛选项下有筛选值选中时,替换
				}else{
					$replace_option [] = $get_narrow[$no];
				}
			}

			$narrow_option_values = $this->zen_get_count_products_of_serach_narrow($replace_option,$oID,$keyword,$words,$key_array);

			//只有一个筛选值,并且不是默认筛选项时,不显示
			if(sizeof($narrow_option_values) <2 && $narrow_type != 3){
			}else{

				//end 该筛选项在产品中的赋值

				if(in_array($oID,$get_narrow_option) || $narrow_by_hidding){
					$display_css_class = 'sidebar_06_js';
					$display_dd_css_class = '';
				}else{
					$display_css_class = 'sidebarForJS';
					//$display_dd_css_class = 'display_none';
				}

				$css_type = $this->fs_narrow_by_opions_css_type($oID);   //筛选项样式
				switch ($css_type){
					case '2':
						$narrow_css  ='two_column';
						break;
					case '3':
						$narrow_css  ='three_column';
						break;
					default:
						$narrow_css  ='';
						break;
				}




				$narrow_by_values = $this->fs_narrow_by_opions_values_by_oID_products($oID);   //分类产品筛选项下的筛选值

				//筛选后的产品,拥有的筛选值.用来识别没有无结果的筛选值,隐藏

				if(sizeof($products_narrow_value)){
					$narrow_by_values = $this->sort_order_narrow_by_values($narrow_by_values);     //筛选值排序
					$nvi = 0;$cDIV = false;
					foreach ($narrow_by_values as $ii => $vID){

						$hideNV=false;
						$is_current= $narrow_get_parmas_string = '';
						//$page = FILENAME_NARROW;
						$except_values = array('cPath','narrow');
						$new_narrow_by_array = array();
						$href =$name=$count_of_narrow_by_products= '';
						$class='';
						if (zen_not_null($get_narrow)) {
							if (in_array($vID,$get_narrow)) {  //已选择的筛选值,添加样式
								$is_current = 'xiand';
								$class = $is_current;
							}
						}
						else {
							$new_narrow_by_array = array();
						}
						$_GET['narrow']= $new_narrow_by_array;

						//var_dump($get_narrow);
						$narrow_url = '';
						$replace_narrow = array();

						//如果下一步选择的筛选值和已选择的筛选值属于同一个筛选项,那么新的URL 是将选择的筛选值替换已选择的筛选值
						for($ni = 0; $ni< sizeof($get_narrow);$ni++){
							if($vID == $get_narrow[$ni]){                                                   //取消已选择的筛选值
								$narrow_url .='';
							}else if($oID == $get_narrow_option[$ni]){ //当前筛选项下有筛选值选中时,替换
								$replace_narrow [] = $vID;
								$narrow_url .='&narrow[]='.$vID;
							}else{
								$replace_narrow [] = $get_narrow[$ni];
								$narrow_url .='&narrow[]='.$get_narrow[$ni];

							}
						}
						if($get_narrow_option){
							if(!in_array($oID,$get_narrow_option)){        //没有勾选的筛选项
								if(!in_array($vID,$products_narrow_value)){   //如果当前产品没有未勾选筛选项中的筛选值,则筛选值不显示
									$hideNV = true;
								}else{
									$hideNV = false;
									$nvi ++;
								}
							}else{                                         //同选中的筛选项,替换之后会有产品,才能显示
								//if(sizeof($get_narrow_option) > 1){
								//交叉筛选时,才用这个.两个及以上的筛选

								if(in_array($vID,$narrow_option_values)){  //筛选条件下,是否有产品
									$hideNV = false;
									$nvi ++;
								}else{
									$hideNV = true;
								}
								//}
							}
							//过滤该option下的vid  , 从产品中查询是否有该vID
							if(!in_array($oID,$get_narrow_option)){  //除去当前筛选,选择新的筛选值时,新增URL参数
								$narrow_url .='&narrow[]='.$vID;
							}
						}else{
							if(!in_array($vID,$products_narrow_value)){   //如果当前产品没有未勾选筛选项中的筛选值,则筛选值不显示
								$hideNV = true;
							}else{
								$hideNV = false;
								$nvi ++;
							}
							$narrow_url .='&narrow[]='.$vID;
						}
						//$narrow_item = $this->get_all_get_params($except_values,$trim);
						if($narrow_type==3){

							$href= zen_href_link($page,$narrow_url.'&keyword='.$keyword.$params);
						}

						if(!$hideNV){
							$number++;
							$narrow_by_html .= $href;

						}
					}

				}

			}
		}
		if($number==1){
			return $narrow_by_html;
		}
	}


	//分类标签页面筛选项
    function fs_products_narrow_by_list_of_finder($current_category_id,$pids,$get_narrow){
      global $cPath_array;
	  $narrow_by_hidding = false;
      //默认展开
 	  $display_css_class = 'sidebar_06_js';
 	  $display_dd_css_class = '';
	  
      //当前已选择的筛选值代表的筛选项
      if(is_array($get_narrow) && sizeof($get_narrow)){
	       foreach ($get_narrow as $vn => $noID){
	        $select_narrow_option_array [] = zen_get_narrow_by_option_id_of_values_id($noID);
	       }
      }
	  
      $narrow_by_html = '';
	  $category_options = $this->fs_category_products_narrow_option($pids,'narrow','');  //分类产品拥有的筛选项
	  $narrow_by_options = $this->sort_order_narrow_by_options($category_options);  //筛选项排序
	  $trim = true;
	  //筛选项循环
	  $get_narrow_option = array();
	  if(sizeof($get_narrow)){
	      for($ni = 0; $ni< sizeof($get_narrow);$ni++){
				  $get_narrow_option [] = $this->fs_narrow_by_option_id_of_values_id($get_narrow[$ni]);
		  }
	  }
	 
	  $narrow_css ='';$css_type='';
	  foreach ($narrow_by_options as $i => $oID){
	  	$products_narrow_value  = $this->fs_narrow_by_values_by_select_products($oID,$pids);   //当前产品,当前筛选项下拥有的筛选值
	  	
	    if(sizeof($products_narrow_value) <2 && !in_array($oID,$get_narrow_option)){

	    }else{
	  
	  	//剔除该筛选项中被选中的值,判断此时的情况下,产品中对应的筛选项的值
	    $replace_option = array();
	  	for($ni = 0; $ni< sizeof($get_narrow);$ni++){
			    if($oID == $get_narrow_option[$ni]){ //当前筛选项下有筛选值选中时,替换
				}else{
				   	$replace_option [] = $get_narrow[$ni];
				}
		}
		
	    // 该分类下,先剔除当前筛选项,得到其他筛选后的产品,再从产品中判断该筛选项的值
		if(sizeof($get_narrow)){
		$narrow_option_values = $this->zen_get_count_products_of_finder_narrow($replace_option,$oID,$current_category_id);
		}
		/*    默认展开
	     if(in_array($oID,$get_narrow_option)){
	       $display_css_class = 'sidebar_06_js';
 	       $display_dd_css_class = '';
	     }else{
	       $display_css_class = 'sidebarForJS';
	       $display_dd_css_class = 'display_none';
	     }
	   */
		
		 $css_type = $this->fs_narrow_by_opions_css_type($oID);   //筛选项样式
		 switch ($css_type){
		 case '2':
		 $narrow_css  ='two_column';
		 break;
		 case '3':
		 $narrow_css  ='three_column';
		 break;
		 default:
		 $narrow_css  ='';
		 break;
		 }
		
	     $narrow_by_html .= '<dl class="select '.$narrow_css.'"> ';
	   
		 $narrow_by_html .= '<dt>
		                     <a class="'.$display_css_class.'" href="javascript:;">'.$this->get_products_narrow_by_option_name($oID).'</a>
		                    </dt>';
		 
		$narrow_by_values = $this->fs_narrow_by_opions_values_by_oID_products($oID);   //分类产品筛选项下的筛选值
		
		//筛选后的产品,拥有的筛选值.用来识别没有无结果的筛选值,隐藏
		
		if(sizeof($narrow_by_values)){
		$narrow_by_values = $this->sort_order_narrow_by_values($narrow_by_values);     //筛选值排序
		$nvi = 0;$cDIV = false;$hideNV=false;
		foreach ($narrow_by_values as $ii => $vID){
   			$is_current= $narrow_get_parmas_string = '';
			//$page = FILENAME_NARROW;
			$page = FILENAME_TAG_CATEGORIES;
			$new_narrow_by_array = array();
			$href =$name=$count_of_narrow_by_products= '';
			$class='';
			if (zen_not_null($get_narrow)) {
				if (in_array($vID,$get_narrow)) {  //已选择的筛选值,添加样式
					$is_current = 'xiand';
					$class = $is_current;
				}							
			}
			else {
				$new_narrow_by_array = array();
			}
			$_GET['narrow']= $new_narrow_by_array;
						
			$name = $this->get_option_values_name($vID);


			$narrow_url = '';
			$replace_narrow = array();
			
			//其他参数 : 排序,页数,标签
		if (isset($_GET['sort_order']) && $_GET['sort_order']) $narrow_url .='&sort_order='.$_GET['sort_order'].'';
		if (isset($_GET['count']) && intval($_GET['count'])) $narrow_url .='&count='.$_GET['count'];
        if (isset($_GET['settab']) ){ $narrow_url .='&settab='.$_GET['settab']; }

			//如果下一步选择的筛选值和已选择的筛选值属于同一个筛选项,那么新的URL 是将选择的筛选值替换已选择的筛选值
			for($ni = 0; $ni< sizeof($get_narrow);$ni++){
			    if($vID == $get_narrow[$ni]){    //取消已选择的筛选值                                         
			        $narrow_url .='';
			    }else if($oID == $get_narrow_option[$ni]){ //当前筛选项下有筛选值选中时,替换
					$narrow_url .='&narrow[]='.$vID;
				}else{
					$narrow_url .='&narrow[]='.$get_narrow[$ni];
				}
			}
			
			if($get_narrow_option){
				if(!in_array($oID,$get_narrow_option)){        //没有勾选的筛选项
				 if(!in_array($vID,$products_narrow_value)){   //如果当前产品没有未勾选筛选项中的筛选值,则筛选值不显示
				 $hideNV = true;
				 }else{
				 $hideNV = false;
				 $nvi ++;
				 }  
				}else{   //同选中的筛选项,替换之后会有产品,才能显示
				   //if(sizeof($get_narrow_option) > 1){
				     //交叉筛选时,才用这个.两个及以上的筛选
				     if(in_array($vID,$narrow_option_values)){  //筛选条件下,是否有产品
				     $hideNV = false;
				     $nvi ++;
				     }else{
				     $hideNV = true;
				     }
	 			   //}
				}
			   //过滤该option下的vid  , 从产品中查询是否有该vID
				if(!in_array($oID,$get_narrow_option)){  //除去当前筛选,选择新的筛选值时,新增URL参数
				  $narrow_url .='&narrow[]='.$vID;
				}
			}else{
				 if(!in_array($vID,$products_narrow_value)){   //如果当前产品没有未勾选筛选项中的筛选值,则筛选值不显示
				 $hideNV = true;
				 }else{
				 $hideNV = false;
				 $nvi ++;
				 }
			  $narrow_url .='&narrow[]='.$vID;
			}

          $href= zen_href_link($page,$narrow_url.'&tag='.$current_category_id);
		    if(!$hideNV){
		        $narrow_by_html .= '<dd class="' .$class. ' '.$display_dd_css_class.'" '.'> ';
		        $narrow_by_html .= '<a href="'.$href.'">'.$name.'</a> ';
				$narrow_by_html .= '</dd>';
		    }	
		  }  
	  }
		  //  end of narrow values foreach
         $narrow_by_html .= '</dl>';
	  }
    }//只有一个筛选值的 筛选项不显示 

	$narrow_by_html = '<div class="sidebar_06">'.$narrow_by_html .'</div>	';
	  return $narrow_by_html;		
    }
	
//指定筛选值-分类下,是否有产品
  function zen_get_count_products_of_serach_narrow($narrow,$oid,$keyword,$word,$key_array){
	 global $db;
	 $advance_search =  new advance_search_detech();
	$return = array();

	$products_narrow_by_option_values_ids = array();

	if (isset($narrow) && is_array($narrow))  {
		foreach ($narrow as $key => $value){
		    if($value > 0){
			$products_narrow_by_option_values_ids [] = (int)$value;
		    }
		}
	}
	
	$narrow_by_count = sizeof($products_narrow_by_option_values_ids);
	$from_narrow_by='';
	if (zen_not_null($products_narrow_by_option_values_ids)){
		if (1 == $narrow_by_count) {
	        $from_narrow_by =" left join ".TABLE_PRODUCTS_NARROW_BY_OPTION_VALUES_TO_PRODUCTS ." as povp on p.products_id = povp.products_id";
	        $and_narrow_by = " and povp.products_narrow_by_options_values_id = ".(int)$products_narrow_by_option_values_ids[0];
		}else {
			$where_narrow_by = ' select t0.products_id from ';
			$sql_query_array = array();
			for($i = 0; $i< $narrow_by_count;$i++){
				$sql_query_array[] = " (select products_id from  ".TABLE_PRODUCTS_NARROW_BY_OPTION_VALUES_TO_PRODUCTS . "
						where products_narrow_by_options_values_id = ".(int)$products_narrow_by_option_values_ids[$i] ."
								      ) as t".$i ." ";
			}
			for($i = 0,$n=sizeof($sql_query_array); $i< $n;$i++){
				if($i){
					$where_narrow_by .=' CROSS JOIN';
				}
					$where_narrow_by .= $sql_query_array[$i];
				if($i){
					$where_narrow_by .= " ON t".($i-1).".products_id = t".$i.".products_id ";
				}
			}
			$and_narrow_by =  " AND p.products_id in(".$where_narrow_by.")";
		}
	}
	
$replace_keyword = str_replace('-', ' ', $keyword);
$replace_keyword = str_replace('=', ' ', $replace_keyword);
$replace_keyword = str_replace('/', ' ', $replace_keyword);
$replace_keyword = str_replace('from', ' ', $replace_keyword);
$words = explode(" ",$replace_keyword);

	if(sizeof($words) > 1){
      $where_str = zen_get_keywords_sql_of_array($keyword);

      $order_by = zen_get_count_by_keywords_of_sort($keyword,$key_array);
	}else{
	      if(substr($keyword, -1) == 's' && strlen($keyword) > 2){
		       $keyword_cs =  substr($keyword, 0, -1);
		       $keyword_cs = str_replace("s ", "", $keyword_cs);
		       $keyword_cs = trim($keyword_cs);
		   }else{
		   $keyword_cs = trim($keyword);
		   }
           $keyword_cs_regexp = mysql_regexp_transfer($keyword_cs);
	      $where_str = "and REPLACE(pd.products_name,'-',' ') REGEXP '".$keyword_cs_regexp."'";
	 }
      
    $order_by = " order by p.products_sort_order desc";

    
  	if (preg_match('/^SKU/i', $keyword)){
			$listing_sql = "select  p.products_id,p.products_image,p.products_price,p.products_SKU,p.products_model from ".TABLE_PRODUCTS." as p
						where p.products_status = 1	
						and p.products_SKU = :keyword 
						";
			$listing_sql = $db->bindVars($listing_sql, ':keyword', $keyword, 'string');
	}else if($advance_search->search_level($keyword, 2)){
		
		$listing_sql = "select  p.products_id,p.products_image,p.products_price,p.products_SKU,p.products_model from ".TABLE_PRODUCTS." as p
					where p.products_status = 1 
					and (p.products_id = :keyword or p.products_model = :keyword or p.products_MFG_PART = :keyword) order by p.products_sort_order";
		$listing_sql = $db->bindVars($listing_sql, ':keyword', $keyword, 'string');
		
		$final_keyword = $keyword;
	}
	else if(sizeof($words) > 6){
	  $listing_sql = "select p.products_id,p.products_image,p.products_price,p.products_SKU,p.products_model from ".TABLE_PRODUCTS." as p
						left join ".TABLE_PRODUCTS_DESCRIPTION ." as pd on p.products_id = pd.products_id
						where p.products_status = 1	
						and language_id = ".$this->languages_id." 	
						and (pd.products_name = :keyword or pd.products_name REGEXP :keyword )";
        $keyword_regexp = mysql_regexp_transfer($keyword);
	  $listing_sql = $db->bindVars($listing_sql, ':keyword', $keyword_regexp, 'string');
	}else{
       if(sizeof($categories_arr) && $advance_search->search_level($keyword, 5)){
      //add categories tag keyword search
       if ($categories_arr){
	  		if (1 < sizeof($categories_arr)) {
	  			$category_where_sql = " AND ptc.categories_id in(".join(',',$categories_arr).") ";
	  			
	  		}else if (1 == sizeof($categories_arr)) {
	  			$category_where_sql = " AND  ptc.categories_id = ".$categories_arr[0]." ";
	  		}
	  		
	  	}
         $listing_sql = "select  p.products_id from ".TABLE_PRODUCTS." as p
					left join " . TABLE_PRODUCTS_TO_CATEGORIES . " AS ptc on p.products_id = ptc.products_id
					left join category_search_tag as cst on ptc.categories_id = cst.categories_id
					where p.products_status = 1 
					". $category_where_sql ." order by p.products_quantity = 0 ,cst.weight, p.products_sort_order";
		$listing_sql = $db->bindVars($listing_sql, ':keyword', $keyword, 'string');
		
    }else {
         $listing_sql = "select  p.products_id from ".TABLE_PRODUCTS." as p
					left join ".TABLE_PRODUCTS_DESCRIPTION ." as pd on p.products_id = pd.products_id
					".$from_narrow_by."
					where p.products_status = 1 
					and language_id = ".$this->languages_id."
					".$where_str.$and_narrow_by.$order_by."";
		$listing_sql = $db->bindVars($listing_sql, ':keyword', $keyword_cs, 'string');
	
    }
   }

	$get_products = $db->Execute($listing_sql);
	 $products = array();
	 if ($get_products->RecordCount()){
		while (!$get_products->EOF){
			$products [] =  $get_products->fields['products_id'];
			$get_products->MoveNext();
		}
	 }
	 //满足筛选后的产品.求某特定筛选项的值
	 $products_narrow_values = array();
	 if(sizeof($products)){
	   $products_narrow_values = $this->fs_narrow_by_values_by_select_products($oid,$products);
	 }
	 return $products_narrow_values;
	}
	/******** 新筛选项 eof  *********/
    
	//   includes/modules/meta_tags.php on line 244
	function get_option_values_name_by_narrows_id($narrow_by){
		global $db;
		$narrow = array();
		$sql = "select products_narrow_by_options_values_name  as name
			from " . TABLE_PRODUCTS_NARROW_BY_OPTIONS_VALUES. "
			where products_narrow_by_options_values_id in (".join(',',$narrow_by).") and language_id = ".$this->languages_id." "   ;
		//echo $sql."<br>";
		$result = $db->Execute($sql);
		if ($result->RecordCount()){
			while (!$result->EOF){
				$narrow [] = $result->fields['name'];
				$result->MoveNext();
			}
		}
		return $narrow;
	}
	
	// Return all HTTP GET variables, except those passed as a parameter
	function get_all_get_params($exclude_array = '', $trim = true,  $search_engine_safe = true) {
		global $cPath_array;
		$narrow_by_hidding = false;
		$target_categories = array(897,898,1120,1130);
		$display_css_class = 'sidebar_06_js';
		//eof hide patch cable narrow by

		if (!is_array($exclude_array)) $exclude_array = array();
	
		$get_url = '';
		if (is_array($_GET) && (sizeof($_GET) > 0)) {

			reset($_GET);
			ksort($_GET);
			while (list($key, $value) = each($_GET)) {
	
				//if this is array
				if ('narrow' == $key) {
					array_unique($value);
					 
					sort($value,SORT_NUMERIC);
					foreach ($value as $i => $v){
	
						//part 2
						if ($narrow_by_hidding) {
							$sql = "SELECT products_narrow_by_options_id FROM products_narrow_by_options_values_to_options
									WHERE products_narrow_by_options_values_id = " .(int)$v;
							$result = zen_get_data_from_db($sql, array('products_narrow_by_options_id'));
							//if (!$trim || ($trim && !in_array($result[0][0],array(337,340,339,345,341,342,343,357,358,359,360,362,258)))) {
								$get_url.= '&'.$key.'[]='.$v.'&';
							//}
						} else{
							$get_url.= '&'.$key.'[]='.$v.'&';
						}
	
					}
					continue;
				}
				if ( (strlen($value) > 0) && ($key != 'main_page') && ($key != zen_session_name()) && ($key != 'error') && (!in_array($key, $exclude_array)) && ($key != 'x') && ($key != 'y') ) {
					 
					if ( (SEARCH_ENGINE_FRIENDLY_URLS == 'true') && ($search_engine_safe == true) ) {
						$get_url .= $key . '/' . rawurlencode(stripslashes($value)) . '/';
					} else {
						$get_url .= zen_sanitize_string($key) . '=' . rawurlencode(stripslashes($value)) . '&';
					}
				}
			}
		}
		while (strstr($get_url, '&&')) $get_url = str_replace('&&', '&', $get_url);
		while (strstr($get_url, '&amp;&amp;')) $get_url = str_replace('&amp;&amp;', '&amp;', $get_url);
	
		return $get_url;
	}
	//左侧的分类列表 PC和M端的样式不一致  故重新分装一个方法
    function fs_search_products_narrow_by_list_new_pc($pids,$get_narrow,$keyword,$words,$key_array,$search_type='old',$page = FILENAME_ADVANCED_SEARCH_RESULT,$params=''){
        $narrow_by_html = '';
        // 如果是搜索产品id
        if(is_numeric($keyword) && strlen($keyword) >= 5){
            $narrow_by_html .= '<dl class="popularity_view_listz1 new_proList_autoDev">';
            $narrow_by_html .= '<dt class="popularity_view_sortz1"><p>'.BOX_HEADING_CATEGORIES.'<span class="iconfont icon">&#xf087;</span></p></dt><dd class="popularity_view_listz1_li">
                            <div class="popularity_view_listArrow"></div>
                            <div class="popularity_view_listz1_liBox01">';
            $categories_pid = zen_get_subcategories_of_one_category_ids($keyword);
            if(!empty($categories_pid)){
                $where_clearing = ' and is_clearing = 0 ';
                $categories_id = zen_get_subcategories_of_one_category($categories_pid[1],$where_clearing);
                foreach ($categories_id as $z => $cID) {
                    if($cID==$categories_pid[0]){
                        $href = zen_href_link(FILENAME_DEFAULT, 'cPath=' . $cID);
                        $narrow_by_html .= '<div class="popularity_view_listz1_liMain"><a href="'.$href.'"><div class="new_proList_mainLabel">'.zen_get_categories_name($cID).'</div></a></div>';
                    }
                }
            }
            $narrow_by_html .= '</div></dd></dl> ';
            return $narrow_by_html;
        }

        //当前产品组的 所有的筛选项
        if(is_array($get_narrow) && sizeof($get_narrow)){
            $narrow_by_options = $this->fs_search_products_narrow_option_new($pids,'narrow','');  //类型为narrow的筛选项,已去重,已排序
        }else{
            // 第一次搜索关键字
            $narrow_by_options = $this->fs_search_products_narrow_option_new($pids,'','',BOX_HEADING_CATEGORIES);  //默认的筛选项,已去重,已排序
            $narrow_by_options = $narrow_by_options[0];
            $oID = $narrow_by_options['id']; //筛选项ID
            $narrow_name = $narrow_by_options['narrow_name'];   //筛选项名称
            $products_narrow_value  = $this->fs_narrow_by_values_by_select_products_new($oID,$pids);   //筛选项、搜索出来的的产品，拥有的筛选值
            $narrow_by_values = $products_narrow_value; //循环的是：右侧筛选出来的产品、当前筛选项的筛选值。不需要判断是否显示隐藏，全部显示
            if(sizeof($products_narrow_value)){
                $narrow_by_html .= '<dl class="popularity_view_listz1 new_proList_autoDev">';
                $narrow_by_html .= '<dt class="popularity_view_sortz1"><p>'.$narrow_name.'<span class="iconfont icon">&#xf087;</span></p></dt><dd class="popularity_view_listz1_li" style="display: none; opacity: 1;"> 
                            <div class="popularity_view_listArrow"></div>
                            <div class="popularity_view_listz1_liBox01">';
                // 筛选值循环start
                foreach ($narrow_by_values as $ii => $narrow_by_values_val){
                    $vID = $narrow_by_values_val['id'];
                    $name = $narrow_by_values_val['name'];
                    $list_not_alink_class='';
                    if (zen_not_null($get_narrow) || isset($_GET['narrow'])) {
                        if (in_array($vID,$get_narrow) || in_array($vID,$_GET['narrow'])) {  //已选择的筛选值,添加样式
                            $list_not_alink_class = 'choosez';
                        }
                    }
                    // 获取当前筛选值的链接
                    $narrow_url = '';
                    //如果不存在选中的筛选项。比较简单
                    $narrow_url .='&narrow[]='.$vID;
                    $href= zen_href_link($page,$narrow_url.'&keyword='.$keyword.$params);
                    $narrow_by_html .= '<div class="popularity_view_listz1_liMain">';
                    $narrow_by_html .= '<a href="'.$href.'"><div class="new_proList_mainLabel '.$list_not_alink_class.'">'.$name.'</div></a></div>';
                }
                // 筛选值循环 end
                $narrow_by_html .= '</div></dd></dl>';
            }

            return $narrow_by_html;
        }

        // 获取已经选中的筛选项
        $get_narrow_option = array();
        if(sizeof($get_narrow)){
            for($ni = 0; $ni< sizeof($get_narrow);$ni++){
                $get_narrow_option [] = $this->fs_narrow_by_option_id_of_values_id($get_narrow[$ni]);
            }
        }

        //筛选项循环start
        foreach ($narrow_by_options as $i => $narrow_by_options_val){
            $oID = $narrow_by_options_val['id']; //筛选项ID
            $css_type = $narrow_by_options_val['css_type'];   //筛选项样式
            $narrow_name = $narrow_by_options_val['narrow_name'];   //筛选项名称
            $narrow_type = $narrow_by_options_val['narrow_type'];   //筛选项名称
            // 是否默认展示
            $default_show = 1;
            if($narrow_by_options_val['default_not_show'] !== ''){
                $default_not_show_arr = explode(',', $narrow_by_options_val['default_not_show']);
                if(in_array(0,$default_not_show_arr)) {
                    $default_show = 0;
                }
            }

            $products_narrow_value  = $this->fs_narrow_by_values_by_select_products_new($oID,$pids);   //筛选项、搜索出来的的产品，拥有的筛选值

            if(!$get_narrow || ($get_narrow && !in_array($oID,$get_narrow_option) )){ // 没有选中筛选项 或者 当前的筛选项下面没有选中
                $products_narrow_value_count = count($products_narrow_value);
                if($narrow_type != 3 && $products_narrow_value_count < 2){ //如果只有一个筛选值,则不显示
                    continue;
                }
                $narrow_by_values = $products_narrow_value; //循环的是：右侧筛选出来的产品、当前筛选项的筛选值。不需要判断是否显示隐藏，全部显示
            }else{ // 有选中筛选项，当前的筛选项下面有选中
                //剔除该筛选项中被选中的值,判断此时的情况下,产品中对应的筛选项的值
                $replace_option = array();
                for($no = 0; $no< sizeof($get_narrow);$no++){
                    if($oID == $get_narrow_option[$no]){ //当前筛选项下有筛选值选中时,替换
                    }else{
                        $replace_option [] = $get_narrow[$no];
                    }
                }

                if($search_type == 'old'){ //用原来的搜索
                    $all_search_product = get_old_search_all_products($keyword,$words,$key_array,$replace_option);
                }else{
                    $all_search_product = get_amazon_search_all_products($keyword,$replace_option);
                }
                $narrow_option_values = array();
                if(sizeof($all_search_product)){
                    $narrow_option_values = $this->fs_narrow_by_values_by_select_products($oID,$all_search_product);
                }

                //只有一个筛选值,并且不是默认筛选项时,不显示
                if(sizeof($narrow_option_values) <2 && $narrow_type != 3){
                    continue;
                }else{
                    $narrow_by_values = $this->fs_narrow_by_values_by_select_products_new($oID);   //分类产品筛选项下的筛选值
                }
            }
            switch ($css_type){
                case '2':
                    $narrow_css  ='two_column';
                    break;
                case '3':
                    $narrow_css  ='three_column';
                    break;
                default:
                    $narrow_css  ='';
                    break;
            }
            if(!is_numeric($keyword)){
                $narrow_by_html .= '<dl class="popularity_view_listz1 new_proList_autoDev '.$narrow_css.'"> ';
                $narrow_by_html .= '<dt class="popularity_view_sortz1"><p>'.$narrow_name.'<span class="iconfont icon">&#xf087;</span></p></dt><dd class="popularity_view_listz1_li" style="display: none; opacity: 1;"><div class="popularity_view_listArrow"></div><div class="popularity_view_listz1_liBox01">';
                if(sizeof($products_narrow_value)){
                    // 筛选值循环start
                    foreach ($narrow_by_values as $ii => $narrow_by_values_val){
                        $hideNV = false;
                        $vID = $narrow_by_values_val['id'];
                        $name = $narrow_by_values_val['name'];
                        $class='';
                        if (zen_not_null($get_narrow)) {
                            if (in_array($vID,$get_narrow)) {  //已选择的筛选值,添加样式
                                $class = 'choosez';
                            }
                        }
                        // 获取当前筛选值的链接
                        $narrow_url = '';
                        if($get_narrow){
                            // 对当前的网址（也就是当前选中的筛选项值）进行处理。
                            for($ni = 0; $ni< sizeof($get_narrow);$ni++){
                                if($vID == $get_narrow[$ni]){ //取消已选择的筛选值（已经选中，再次点击取消）
                                    $narrow_url .='';
                                }else if($oID == $get_narrow_option[$ni]){ // 当前筛选值 和选中筛选值 在同一个筛选项下面，进行替换
                                    $narrow_url .='&narrow[]='.$vID;
                                }else{ //都不是，保留原来已经选中的的筛选值
                                    $narrow_url .='&narrow[]='.$get_narrow[$ni];
                                }
                            }
                            //除去当前筛选,选择新的筛选值时,新增URL参数
                            if(!in_array($oID,$get_narrow_option)){
                                $narrow_url .='&narrow[]='.$vID;
                            }
                        }else{ //如果不存在选中的筛选项。比较简单
                            $narrow_url .='&narrow[]='.$vID;
                        }
                        if($get_narrow){
                            if(in_array($oID,$get_narrow_option)){//筛选项下面有选中的时候
                                if(!in_array($vID,$narrow_option_values)){  //该筛选值条件，没有产品不显示
                                    $hideNV = true;
                                }
                            }
                        }
                        if(!$hideNV){
                            $href= zen_href_link($page,$narrow_url.'&keyword='.$keyword.$params);
                            $narrow_by_html .= '<div class="popularity_view_listz1_liMain">
                                    <a href="'.$href.'">
                                        <div class="new_proList_mainLabel '.$class.'">'.$name.'</div>
                                    </a>
                                </div>';
                        }
                    }
                    // 筛选值循环 end
                }
                $narrow_by_html .= '</div></dd></dl>';
            }
        }
        //  筛选项循环 end
        return $narrow_by_html;
    }
}