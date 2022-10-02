<?php
class fiberstore_category{

    /**
     *
     * @return array sub categories of root category
     * 2018.7.5/7.14 小语种/英文新版首页上线 fairy 增加categories_of_image
     *
     * @param $flag   //有些地方不需要 get_second_categories   故做此控制  rebirth.ma  2019/03/29
     */
    static function get_subs_of_root_category($cid,$flag = true)
    {
        global $db;
        $transceivers = array();
        $categories_custom = zen_get_categories_has_custom_display($cid,$level=2);
        //有自定义的2级分类
        if(!empty($categories_custom)){
            $transceivers = $categories_custom;
            $transceivers['custom'] = true;
        }else{
            $sql= "select c.categories_id as id,parent_id as pid, categories_name as name,c.categories_of_image,c.categories_of_image_mobile,c.categories_of_image_app from " .TABLE_CATEGORIES . " as c left join " .
                TABLE_CATEGORIES_DESCRIPTION  ." as cd
            on (c.categories_id = cd.categories_id)
            where c.categories_status = 1
            and c.parent_id = ".(int)$cid."
            and cd.language_id = " .(int)$_SESSION['languages_id'] . "
            order by c.sort_order ";
            $result = $db->Execute($sql);
            if ($flag){
                while (!$result->EOF){
                    $transceivers [] = array(
                        'id'=>$result->fields['id'],
                        'name'=>swap_american_to_britain($result->fields['name']),
                        'categories_of_image'=>$result->fields['categories_of_image'],
                        'categories_of_image_mobile'=>$result->fields['categories_of_image_mobile'],
                        'categories_of_image_app'=>$result->fields['categories_of_image_app'],
                        'subs'=>fiberstore_category::get_second_categories($result->fields['id'])
                    );
                    $result->MoveNext();
                }
            }else{
                while (!$result->EOF){
                    $transceivers [] = array(
                        'id'=>$result->fields['id'],
                        'name'=>swap_american_to_britain($result->fields['name']),
                        'categories_of_image'=>$result->fields['categories_of_image'],
                        'categories_of_image_mobile'=>$result->fields['categories_of_image_mobile'],
                        'categories_of_image_app'=>$result->fields['categories_of_image_app']
                    );
                    $result->MoveNext();
                }
            }

        }

        return $transceivers;
    }

	/**
	 * get special offers ***************************************
	 */
	static function get_special_offers($cid)
	{
		global $db;
		$arr = array();
		$sql= "select special_offers_name as name, special_offers_link as link from ".TABLE_SPECIAL_OFFERS_DESCRIPTION." 
		  		where
		  		languages_id = " .(int)$_SESSION['languages_id'] . " 
		  		and categories_id = ".(int)$cid."
		  		order by sort_by,special_offers_id desc ";
		//die($sql);
		$result = $db->Execute($sql);
		while (!$result->EOF){
			$arr [] = array(
					'name' => $result->fields['name'],
					'link' => $result->fields['link']
				);
			$result->MoveNext();
		}

		return $arr;
	}

	static function get_special_title($cid){
		global $db;
		$arr = array();
		$sql= "select title,img_url,img_link from special_title where languages_id = " .(int)$_SESSION['languages_id'] . " and categories_id = ".(int)$cid."
		  		 limit 1 ";
		$result = $db->Execute($sql);
		if($result->RecordCount()){
			$arr = array(
					'title' => $result->fields['title'],
					'img_url' => $result->fields['img_url'],
					'img_link' => $result->fields['img_link']
				);
		}
		return $arr;
	}

	static function get_second_categories($pid)
	{
		global $db;
		$arr = array();
		$sql= "select c.categories_id as id,parent_id as pid,categories_image as image,categories_of_image_app, categories_name as name,categories_description as description  from " .TABLE_CATEGORIES . " as c left join " .
				TABLE_CATEGORIES_DESCRIPTION  ." as cd
  		on (c.categories_id = cd.categories_id)
  		where c.categories_status = 1  		
  		and c.is_clearing = 0 
  		and cd.language_id = " .(int)$_SESSION['languages_id'] . " 
  		and c.parent_id = ".(int)$pid ." 
  		order by c.sort_order ";
		$result = $db->Execute($sql);
		$i =0;
		while (!$result->EOF){
			$arr [] = array(
					'id'=>$result->fields['id'],
					'name'=>$result->fields['name'],
					'image'=>$result->fields['image'],
					'categories_of_image_app' => $result->fields['categories_of_image_app'],
					'description' => $result->fields['description'],
					);
			$result->MoveNext();
		}
		return $arr;
	}
	static function get_sub_categories_of_current_category($cid){
		return fiberstore_category::get_second_categories($cid);
	}


	static function get_recommend_categories_id(){
		global $db;
		$arr = array();
		  $recommend_sql = " select  categories_id as id from ".TABLE_CATEGORIES_DESCRIPTION." where recommend_id =1 and language_id = ".(int)$_SESSION['languages_id']." ";
          $result = $db->Execute($recommend_sql);
          while (!$result->EOF){
          	$arr []= $result->fields['id'];
            $result->MoveNext();
           }
        return $arr;
	}

	static function display_subcategories($categories, $root_categories_id = 0){
        global $db;
		if(0 != $root_categories_id) $class = ' root_category';
		$html = '<div class="fs_category_list'.$class.'">';

        $recommend = fiberstore_category::get_recommend_categories_id();
        //自定义二级分类
        if($categories['custom']){
            // $categories['custom']多占了一个元素, -1
            for ($i = 0,$n =sizeof($categories)-1; $i < $n;$i++){
                $html .='<dl>';
                if($categories[$i]['red'] == 1){
                    $html .='<dt><a class="recommend_red" href="'. $categories[$i]['url'] .'">'.$categories[$i]['name'].'</a></dt>';
                }else{
                    $html .='<dt><a href="'. $categories[$i]['url'] .'">'.$categories[$i]['name'].'</a></dt>';
                }

                $categories_custom_third = zen_get_categories_has_custom_display($categories[$i]['cid'],$level=3);

                if($len = sizeof($categories_custom_third)){
                    for($l=0;$l<$len;$l++){
                        if($categories_custom_third[$l]['red'] == 1){
                            $html .='<dd><a class="recommend_red" href="'. $categories_custom_third[$l]['url'] .'">'.$categories_custom_third[$l]['name'].'</a></dd>';
                        }else{
                            $html .='<dd><a href="'. $categories_custom_third[$l]['url'] .'">'.$categories_custom_third[$l]['name'].'</a></dd>';
                        }
                    }
                }elseif($categories[$i]['categories_id']){
                    $subs = fiberstore_category::get_second_categories($categories[$i]['categories_id']);
                    if(sizeof($subs)){
                        foreach ($subs as $ii => $category){
                            if(!in_array($category['id'],$recommend)){
                                $html .='<dd><a href="'.zen_href_link(FILENAME_DEFAULT,'&cPath='.$category['id'],'SSL').'">'.$category['name'].'</a></dd>';
                            }else{
                                $html .='<dd><a class="recommend_red" href="'.zen_href_link(FILENAME_DEFAULT,'&cPath='.$category['id'],'SSL').'">'.$category['name'].'</a></dd>';
                            }
                        }
                    }
                }

                $html .='</dl>';
                if(0 == $root_categories_id){
                    if (0<$i && 0 == ($i+1) % 3 ) {
                        $html .='<div class="ccc"></div>';
                    }
                }else{
                    if (0 == ($i+1) % 4 ) {
                        $html .='<div class="ccc"></div>';
                    }
                }
            }
        }
        else{
            for ($i = 0,$n =sizeof($categories); $i < $n;$i++){
                $id = $categories[$i]['id'];
                $name = $categories[$i]['name'];
                $subs = $categories[$i]['subs'];

                $html .='<dl>';

                if(!in_array($id,$recommend)){
                    $html .='<dt><a href="'.zen_href_link(FILENAME_DEFAULT,'&cPath='.$id,'SSL').'">'. $name.'</a></dt>';
                }else{
                    $html .='<dt><a class="recommend_red" href="'.zen_href_link(FILENAME_DEFAULT,'&cPath='.$id,'SSL').'">'. $name.'</a></dt>';
                }

                $result = $db->Execute("select cid from categories_left_display where categories_id=".$id." and language_id = " .(int)$_SESSION['languages_id']);
                $categories_custom_third = zen_get_categories_has_custom_display($result->fields['cid'],$level=3);
                if($len = sizeof($categories_custom_third)){
                    for($l=0;$l<$len;$l++){
                        if($categories_custom_third[$l]['red'] == 1){
                            $html .='<dd><a class="recommend_red" href="'. $categories_custom_third[$l]['url'] .'">'.$categories_custom_third[$l]['name'].'</a></dd>';
                        }else{
                            $html .='<dd><a href="'. $categories_custom_third[$l]['url'] .'">'.$categories_custom_third[$l]['name'].'</a></dd>';
                        }
                    }
                }else{
                    //if(get_fiberstore_parent_categories_id($id)!=573){
                        if(sizeof($subs)){
                            foreach ($subs as $ii => $category){
                                if(!in_array($category['id'],$recommend)){
                                    $html .='<dd><a href="'.zen_href_link(FILENAME_DEFAULT,'&cPath='.$category['id'],'SSL').'">'.$category['name'].'</a></dd>';
                                }else{
                                    $html .='<dd><a class="recommend_red" href="'.zen_href_link(FILENAME_DEFAULT,'&cPath='.$category['id'],'SSL').'">'.$category['name'].'</a></dd>';
                                }
                            }
                        }
                    //}
                }

                $html .='</dl>';
                if(0 == $root_categories_id){
                    if (0<$i && 0 == ($i+1) % 3 ) {
                        $html .='<div class="ccc"></div>';
                    }
                }else{
                    if (0 == ($i+1) % 4 ) {
                        $html .='<div class="ccc"></div>';
                    }
                }
            }
        }
		return $html.'</div>';
	}


	static function display_sub_specialoffers($categories){
		$html = '';
		for ($i = 0,$n =sizeof($categories); $i < $n;$i++){
			$name = $categories[$i]['name'];
			$links = $categories[$i]['link'];
 			$html .='<dd> <a href="'.$links.'">'.$name.'</a></dd>';

		}
		return $html;
	}


	static function show_categories(){

		global $db;

		$html = '';

        $file_path = DIR_FS_SQL_CACHE.'/htmls/';
        $file_name = 'category_tree.html';
        $file_path_name = $file_path.$file_name;

		//if cache file exists, read it and return
		if (cacheFactory::get_cached_file_contents($file_path_name, $html)) {
			return $html;
		}

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
			for ($i =0;$i<$size; $i++){

				$root_categories_id = 0;
				if(!in_array($arr[$i],array(9)) ) {
					$root_categories_id = 0;
				}else{
				   $root_categories_id = 1;
				}

				$html .= '
						
						<div class="item"> ';
				if($i == ($size - 1)){
					$html .= '		<span style="border-bottom:#ccc;">';
				}else{
					$html .= '		<span> ';
				}
                $html .= '      <h3><a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[$i],'SSL').'">'.zen_get_categories_name((int)$arr[$i]).'</a></h3>
                                   		</span>
                                   <div class="i-mc big_01">
                                        <div class="subitem">';

				//if( 209 == (int)$arr[$i]) $root_categories_id = (int)$arr[$i];
                $html .=  fiberstore_category::display_subcategories(fiberstore_category::get_subs_of_root_category((int)$arr[$i]),$root_categories_id);


				$html .='</div>';
				if(!in_array($arr[$i],array(9)) ) {
					$title_arry = fiberstore_category::get_special_title((int)$arr[$i]);
					if($title_arry){
						$special_offers = $title_arry['title'];
						$special_offer_category_image = DIR_WS_IMAGES.$title_arry['img_url'];
						$custom_href = $title_arry['img_link'];
						$alt = zen_get_categories_name($arr[$i]);
					}else{
						//引入后台自定义的图片，alt，url
						$colums = array('pc_path','alt','url');
						$catemenu_banner = fs_get_data_from_db_fields_array($colums,'fs_banner_manage_new','groups=3 and language_id='.$_SESSION['languages_id'].' and category_id='.(int)$arr[$i],'');

						$special_offers = 'Spotlight';
						if(sizeof($catemenu_banner)){
							$special_offer_category_image = $catemenu_banner[0][0];
							$custom_href = $catemenu_banner[0][2];
							$alt = $catemenu_banner[0][1];
						}else{
							$special_offer_category_image = DIR_WS_IMAGES.zen_get_categories_image((int)$arr[$i]);		//分类图片地址
							$custom_href = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[$i],'SSL');				//图片指定的链接
							$alt = zen_get_categories_name($arr[$i]);
						}

						//$special_offer_category_image = DIR_WS_IMAGES.zen_get_categories_image((int)$arr[$i]);
						//$custom_href = zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[$i],'SSL');
					}
					$html .='    <div class="special_offers"><div><b>'.$special_offers.'</b></div>  
									<div class="special_offers_1">';

					$html .= fiberstore_category::display_sub_specialoffers(fiberstore_category::get_special_offers((int)$arr[$i]));

					$html .=' </div> </div> <div class="special_offers_2">  ';
					if($special_offer_category_image || file_exists($special_offer_category_image)){
						if($arr[$i] != 4){
						  $html .='  <a href="'.$custom_href.'">
						           <img alt="'.$alt.'" src="'.zen_get_img_change_src($special_offer_category_image).'"/>
						           </a>   '   ;
						}else{
							 $html .='  <a href="'.$custom_href.'">
						           <img alt= "One-Click MTP/MPO Cleaner" src="'.zen_get_img_change_src($special_offer_category_image).'"/>
						           </a>   '   ;
						}


					}

					$html .=' 	</div>	<div class="close"></div>';

				}
				$html .='</div></div>  ';

			}
		}

		//cache categories html contents
		cacheFactory::save_caching_file_contents($file_name, $file_path, $html);
		return $html;
	}


	//fallwind	2017.5.4	分类树的二级分类-新
	static function display_subcategories_new_home($categories, $root_categories_id = 0){
        global $db;
		//if(0 != $root_categories_id) $class = ' root_category';
		$html = '<div class="banner_left_more_one_main_font">';

        $recommend = fiberstore_category::get_recommend_categories_id();
        //自定义二级分类
        if($categories['custom']){
            // $categories['custom']多占了一个元素, -1
            for ($i = 0,$n =sizeof($categories)-1; $i < $n;$i++){
                $html .='<dl>';
                if($categories[$i]['red'] == 1){
                    $html .='<dt><a class="recommend_red" href="'. $categories[$i]['url'] .'">'.$categories[$i]['name'].'</a></dt>';
                }else{
                    $html .='<dt><a href="'. $categories[$i]['url'] .'">'.$categories[$i]['name'].'</a></dt>';
                }

                $categories_custom_third = zen_get_categories_has_custom_display($categories[$i]['cid'],$level=3);

                if($len = sizeof($categories_custom_third)){
                    for($l=0;$l<$len;$l++){
                        if($categories_custom_third[$l]['red'] == 1){
                            $html .='<dd><a class="recommend_red" href="'. $categories_custom_third[$l]['url'] .'">'.$categories_custom_third[$l]['name'].'</a></dd>';
                        }else{
                            $html .='<dd><a href="'. $categories_custom_third[$l]['url'] .'">'.$categories_custom_third[$l]['name'].'</a></dd>';
                        }
                    }
                }elseif($categories[$i]['categories_id']){
                    $subs = fiberstore_category::get_second_categories($categories[$i]['categories_id']);
                    if(sizeof($subs)){
                        foreach ($subs as $ii => $category){
                            if(!in_array($category['id'],$recommend)){
                                $html .='<dd><a href="'.zen_href_link(FILENAME_DEFAULT,'&cPath='.$category['id'],'SSL').'">'.$category['name'].'</a></dd>';
                            }else{
                                $html .='<dd><a class="recommend_red" href="'.zen_href_link(FILENAME_DEFAULT,'&cPath='.$category['id'],'SSL').'">'.$category['name'].'</a></dd>';
                            }
                        }
                    }
                }

                $html .='</dl>';
                if(0 == $root_categories_id){
                    if (0<$i && 0 == ($i+1) % 3 ) {
                        $html .='<div class="ccc"></div>';
                    }
                }else{
                    if (0 == ($i+1) % 4 ) {
                        $html .='<div class="ccc"></div>';
                    }
                }
				if(0 == ($i+1) % 3){
					$html .='<div class="three"></div>';
				}
            }
        }
        else{
            for ($i = 0,$n =sizeof($categories); $i < $n;$i++){
                $id = $categories[$i]['id'];
                $name = $categories[$i]['name'];
                $subs = $categories[$i]['subs'];

                $html .='<dl>';

                if(!in_array($id,$recommend)){
                    $html .='<dt><a href="'.zen_href_link(FILENAME_DEFAULT,'&cPath='.$id,'SSL').'">'. $name.'</a></dt>';
                }else{
                    $html .='<dt><a class="recommend_red" href="'.zen_href_link(FILENAME_DEFAULT,'&cPath='.$id,'SSL').'">'. $name.'</a></dt>';
                }

                $result = $db->Execute("select cid from categories_left_display where categories_id=".$id." and language_id = " .(int)$_SESSION['languages_id']);
                $categories_custom_third = zen_get_categories_has_custom_display($result->fields['cid'],$level=3);
                if($len = sizeof($categories_custom_third)){
                    for($l=0;$l<$len;$l++){
                        if($categories_custom_third[$l]['red'] == 1){
                            $html .='<dd><a class="recommend_red" href="'. $categories_custom_third[$l]['url'] .'">'.$categories_custom_third[$l]['name'].'</a></dd>';
                        }else{
                            $html .='<dd><a href="'. $categories_custom_third[$l]['url'] .'">'.$categories_custom_third[$l]['name'].'</a></dd>';
                        }
                    }
                }else{
                    //if(get_fiberstore_parent_categories_id($id)!=573){
                        if(sizeof($subs)){
                            foreach ($subs as $ii => $category){
                                if(!in_array($category['id'],$recommend)){
                                    $html .='<dd><a href="'.zen_href_link(FILENAME_DEFAULT,'&cPath='.$category['id'],'SSL').'">'.$category['name'].'</a></dd>';
                                }else{
                                    $html .='<dd><a class="recommend_red" href="'.zen_href_link(FILENAME_DEFAULT,'&cPath='.$category['id'],'SSL').'">'.$category['name'].'</a></dd>';
                                }
                            }
                        }
                    //}
                }

                $html .='</dl>';
                if(0 == $root_categories_id){
                    if (0<$i && 0 == ($i+1) % 3 ) {
                        $html .='<div class="ccc"></div>';
                    }
                }else{
                    if (0 == ($i+1) % 4 ) {
                        $html .='<div class="ccc"></div>';
                    }
                }
				if(0 == ($i+1) % 3 ){
					$html .='<div class="three"></div>';
				}
            }
        }
		return $html.'</div>';
	}

    // 2018.7.5/7.14 小语种/英文新版首页上线	fairy 新增 分类树的二级分类-新版
    static function display_subcategories_new_home_new($categories, $root_categories_id = 0){
		global $db;
		global $code;
        //if(0 != $root_categories_id) $class = ' root_category';
        $html = '';

        $recommend = fiberstore_category::get_recommend_categories_id();
        //自定义二级分类
        if($categories['custom']){
            // $categories['custom']多占了一个元素, -1
            for ($i = 0,$n =sizeof($categories)-1; $i < $n;$i++){
                $html .='<dl class="header_list_more_ul_main_all_con">';
                $category_img_str = HTTPS_IMAGE_SERVER.'includes/templates/fiberstore/images/new_index/header_list01.jpg';
                if($categories[$i]['categories_of_image']){
                    $category_img_str = zen_get_img_change_src($categories[$i]['categories_of_image']);
//                    if(file_exists($category_img)){
//                        $category_img_str = $category_img;
//                    }
                }
                $html .='<dt><img src="'.$category_img_str.'" width="110px" height="110px" /></dt>';
				$html .='<dd>';
				//分类id 3390 分类链接变成专题页面链接
				//if($categories[$i]['categories_id'] == 3390)	$second_c_link = $code.'/wdm-transport-platform.html';
				$recommend_red = '';
                if($categories[$i]['red'] == 1){
                    $recommend_red = 'recommend_red';
                }
                $html .='<h2>';
                if(!empty($categories[$i]['url'])){
                    $second_c_link = reset_url($categories[$i]['url']);
                    $html .= '<a class="'.$recommend_red.'" href="'. $second_c_link .'">'.swap_american_to_britain($categories[$i]['name']).'</a>';
                }else{////没有链接的情况
                    $html .= '<span class="special_alone_category">'.swap_american_to_britain($categories[$i]['name']).'</a>';
                }

                if ($categories[$i]['is_has_new_products'] == 1) {
                    $html .= '<span class="categories-new">'.NEW_PRODUCTS_TAG.'</span>';
                }
                $html .= '</h2>';
                $categories_custom_third = zen_get_categories_has_custom_display($categories[$i]['cid'],$level=3);

                if($len = sizeof($categories_custom_third)){
                    for($l=0;$l<$len;$l++){
                        $html .='<p>';
                        $recommend_red = '';
                        if($categories_custom_third[$l]['red'] == 1){
                            $recommend_red = 'recommend_red';
                        }
                        $html .= '<a class="'.$recommend_red.'" href="'. reset_url($categories_custom_third[$l]['url']).'"><i>'.swap_american_to_britain($categories_custom_third[$l]['name']).'</i>';
                        if ($categories_custom_third[$l]['is_has_new_products'] == 1) {
                            $html .= '<span class="categories-new">'.NEW_PRODUCTS_TAG.'</span>';
                        }

                        if ($categories_custom_third[$l]['is_has_hot_products'] == 1) {
                            $html .= '<span class="categories-hot">'.HOT_PRODUCTS_TAG.'</span>';
                        }
                        $html .= '</a></p>';
                    }
                }elseif($categories[$i]['categories_id']){
                    $subs = fiberstore_category::get_second_categories($categories[$i]['categories_id']);
                    if(sizeof($subs)){
                        foreach ($subs as $ii => $category){
                            if(!in_array($category['id'],$recommend)){
                                $html .='<p><a href="'.zen_href_link(FILENAME_DEFAULT,'&cPath='.$category['id'],'SSL').'">'.$category['name'].'</a></p>';
                            }else{
                                $html .='<p><a class="recommend_red" href="'.zen_href_link(FILENAME_DEFAULT,'&cPath='.$category['id'],'SSL').'">'.$category['name'].'</a></p>';
                            }
                        }
                    }
                }

                $html .='</dd></dl>';
                if(0 == ($i+1) % 3){
                    $html .='<div class="ccc"></div>';
                }
            }
        }
        else{
            for ($i = 0,$n =sizeof($categories); $i < $n;$i++){
                $id = $categories[$i]['id'];
                $name = $categories[$i]['name'];
                $subs = $categories[$i]['subs'];

                $html .='<dl class="header_list_more_ul_main_all_con">';
                $category_img_str = HTTPS_IMAGE_SERVER.'includes/templates/fiberstore/images/new_index/header_list01.jpg';
                if($categories[$i]['categories_of_image']){
                    $category_img_str = zen_get_img_change_src($categories[$i]['categories_of_image']);
//                    if(file_exists($category_img)){
//                        $category_img_str = $category_img;
//                    }
                }
                $html .='<dt><img src="'.$category_img_str.'" width="110px" height="110px" /></dt>';
				$html .= '<dd>';
				$second_c_link = zen_href_link(FILENAME_DEFAULT,'&cPath='.$id,'SSL');
				//分类id 3319 分类链接变成专题页面链接
				if($id == 3319) $second_c_link = $code.'/fs-raceway-solution.html';
				$html .= '<h2>';
                if(!in_array($id,$recommend)){
                    $html .='<a href="'.$second_c_link.'">'. swap_american_to_britain($name).'</a>';
                }else{
                    $html .='<a class="recommend_red" href="'.$second_c_link.'"><i>'. swap_american_to_britain($name).'</i>';
                }
                if ($categories[$i]['is_has_new_products'] == 1) {
                    $html .= '<span class="categories-new">'.NEW_PRODUCTS_TAG.'</span>';
                }
                $html .= '</a></h2>';

                $result = $db->Execute("select cid from categories_left_display where categories_id=".$id." and language_id = " .(int)$_SESSION['languages_id']);
                $categories_custom_third = zen_get_categories_has_custom_display($result->fields['cid'],$level=3);
                if($len = sizeof($categories_custom_third)){
                    for($l=0;$l<$len;$l++){
                        $recommend_red = '';
                        $html .= '<p>';
                        if($categories_custom_third[$l]['red'] == 1) {
                            $recommend_red = 'recommend_red';
                        }
                        $html .= '<a class="'.$recommend_red.'" href="'. reset_url($categories_custom_third[$l]['url']) .'"><i>'.swap_american_to_britain($categories_custom_third[$l]['name']).'</i>';
                        if($categories_custom_third[$l]['is_has_new_product'] == 1) {
                            $html .= '<span class="categories-new">'.NEW_PRODUCTS_TAG.'</span>';
                        }
                        $html .= '</a></p>';

                    }
                }else{
                    if(sizeof($subs)){
                        foreach ($subs as $ii => $category){
                            if(!in_array($category['id'],$recommend)){
                                $html .='<p><a href="'.zen_href_link(FILENAME_DEFAULT,'&cPath='.$category['id'],'SSL').'">'.$category['name'].'</a></p>';
                            }else{
                                $html .='<p><a class="recommend_red" href="'.zen_href_link(FILENAME_DEFAULT,'&cPath='.$category['id'],'SSL').'">'.$category['name'].'</a></p>';
                            }
                        }
                    }
                }
                $html .='</dd></dl>';
                if(0 == ($i+1) % 3 ){
                    $html .='<div class="ccc"></div>';
                }
            }
        }
        return $html;
    }

	//fallwind  2017.5.4	新首页
	static function display_sub_specialoffers_new_home($categories){
		$html = '';
		for ($i = 0,$n =sizeof($categories); $i < $n;$i++){
			$name = $categories[$i]['name'];
			$links = $categories[$i]['link'];
			$open = "";
			$class ="";
			if($links=="https://www.fs.com/solution_support.html?type=1"){
				$open ="onclick=\"javascript:window.open('https://www.fs.com/solution_support.html?type=1&&entrance=1', 'c_TW', 'location=no, toolbar=no, resizable=yes, scrollbars=yes, directories=no, status=no, width=803, height=715, left=500, top=100'); return false;\"";
				$class ='class="remove_position_a"';
				$links ="javascript:;";
			}
			if($links == "nopointer"){
				$html .='<p class="remove_position_p">'.$name.'</p>';
			}else{
				$html .='<a href="'.$links.'" '.$class." ".$open.'>'.$name.'</a>';
			}

		}
		return $html;
	}

    //2018.7.5/7.14 小语种/英文新版首页上线	fairy 新增 分类树-新版
    static function show_categories_new_home_new(){
        global $db;
        $html = '';
        $categories_ids = [];

        /*获取顶级分类id*/
        //不展示一级分类pre_order
        $arr = array();
        $sql= "select c.categories_id as id from " .TABLE_CATEGORIES . " as c left join " .
            TABLE_CATEGORIES_DESCRIPTION  ." as cd
  		on (c.categories_id = cd.categories_id)
  		where c.categories_status = 1
  		and cd.language_id = " .(int)$_SESSION['languages_id'] . "
  		and c.parent_id = 0 and c.categories_id != 3387 
  		order by c.sort_order ";

        $result = $db->Execute($sql);
        if ($result->RecordCount()){
            while (!$result->EOF){
                $arr[] = $result->fields['id'];
                $result->MoveNext();
            }
        }
        /*获取顶级分类id*/

        $size = sizeof($arr);
        if($size){
            //优化结构
            $html .='<div class="home_solution_left"><p class="home_solution_tit">'.FS_ALL_CATEGORIES.'</p>
                        <ul class="home_solution_left_ul">';
            for($i=0;$i<$size;$i++){
                $categories_ids[] = $arr[$i];
                $is_show_str = $li_active_str = '';
                if($i == 0){
                    $li_active_str = 'class="active"';
                }
                $html .='<li '.$li_active_str.'>';
                $html .= '<a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[$i],'NONSSL').'">'.zen_get_categories_name((int)$arr[$i]).'<i class="iconfont icon"></i></a></li>';
//                if($i==0){
//                    $html .='<div class="header_list_more_ul_main show">';
//                }else{
//                    $html .='<div class="header_list_more_ul_main">';
//                }
//                $html .='<div class="header_list_more_ul_main_all '.$_SESSION['languages_code'].'">';
//                $html .= fiberstore_category::display_subcategories_new_home_new(fiberstore_category::get_subs_of_root_category((int)$arr[$i]));
//                $html .='</div></div>';
                $html .='</li>';
            }
            $html .='</ul></div>';
            //获取子分类的HTML结构
            $html .='<div class="home_solution_right">
								<a href="javascript:;" class="iconfont icon home_solution_close">&#xf092;</a>
								<ul class="home_solution_right_ul">';
            foreach ($categories_ids as $key=>$category_id){
                $li_class = '';
                if($key==0){
                    $li_class = 'class="active"';
                }
                $html .= '<li '.$li_class.'><div class="fs_home_product_container"><div class="header_list_more_ul_main_all '.$_SESSION['languages_code'].'">';
                $html .= fiberstore_category::display_subcategories_new_home_new(fiberstore_category::get_subs_of_root_category((int)$category_id));
                $html.= '</div>';
                /*$new_products = get_products_by_cid($category_id,'new_products_tag = 1');
                if(sizeof($new_products)){
                    $html .= '<div class="fs_home_new_product">
                            <div class="fs_home_new_product_bg" style="display: none;"></div>
                            <div id="loader_order_alone" class="loader_order" style="display: none;"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle></svg></div>
                            <h3 class="fs_home_new_product_tit after">'.FS_HEADER_NEW_PRODUCT.'
                                <span>
                                    <a class="fs_home_new_product_change" cid="'.(int)$category_id.'" page="1" href="javascript:;"><i class="iconfont icon">&#xf410;</i><em>'.FS_HEADER_CHANGE.'</em></a>
                                    <a class="fs_home_new_product_more" href="'.zen_href_link('new_product').'"><em>'.FS_COMMON_VIEW_MORE.'</em><i class="iconfont icon">&#xf089;</i></a>
                                </span>
                            </h3>
                            <div class="fs_home_new_product_container">';
                    $html .= get_header_new_products_html($new_products,1);
                    $html .='</div></div>';
                }*/
                $html .= '</div></li>';
            }
            $html .= '</ul></div>';
        }
        return $html;
    }

	public static function show_top_categories_of_left_side_bar($current_category_id){

		$html = '';

		$file_path = DIR_WS_CATALOG.'cache/htmls/';
		$file_name = 'top_category_'.$current_category_id.'.html';
		$file_path_name = $file_path.$file_name;

		//if cache file exists, read it and return
		if (cacheFactory::get_cached_file_contents($file_path_name, $html)) {
			return $html;
		}

		global $db;
        $sql = "SELECT `categories_left_div`  FROM ".TABLE_CATEGORIES_DESCRIPTION." 
		        WHERE categories_id = :categories_id: AND language_id = :languages_id:";
		$sql = $db->bindVars($sql,':languages_id:',(int)$_SESSION['languages_id'],'integer');
		$sql = $db->bindVars($sql,':categories_id:',(int)$current_category_id,'integer');
		$result = $db->Execute($sql);
		//  如果设置了  左边栏就直接返回

	   if ($current_category_id ==1308 || $current_category_id ==1 || $current_category_id ==9 || $current_category_id == 209 || $current_category_id == 3 || $current_category_id == 904  || $current_category_id ==573 || $current_category_id == 911) {
       	    $html .= '';
       }else{
		$html .= '<div class="sidebar">
		               <div class="sidebar_04"> <b>'.zen_get_categories_name($current_category_id).'</b>';

		               if (zen_has_category_subcategories($current_category_id)) {
		               		$categories = zen_get_subcategories_of_one_category($current_category_id);
		               		if (sizeof($categories)) {

		               			foreach ($categories as $i => $sub_categories_id){
		               			$html .= '<dl>';
		               				$category_name = zen_get_categories_name($sub_categories_id);

		               				if (zen_has_category_subcategories($sub_categories_id)) {
		               					$html .= '<dt><a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.$sub_categories_id,'SSL').'">'.$category_name./*zen_get_products_count_of_category($sub_categories_id).*/'</a></dt>';
		               					$categories2 = zen_get_subcategories_of_one_category($sub_categories_id);
										if($current_category_id == 573)continue;

		               				}else {
		               					$html .= '<dt><a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.$sub_categories_id,'SSL').'">'.$category_name./*zen_get_products_count_of_category($sub_categories_id).*/'</a></dt>';
		               				}
		               		    $html .= '</dl>';
		               			}
		               		}
		               }
		               $html .= '    </div>
		          </div>';

       }
       //cache categories html contents
       cacheFactory::save_caching_file_contents($file_name, $file_path, $html);
       return $html;
	}

	static function show_index_categories($cid){
		global $db;
		$html = '';
		$indexName = 'category_index_tree_menu_';
        if(isMobile()){
            $indexName = $indexName.'m_';
        }
//        $version = fs_get_total_from_db('categories_index_menu','categories_id = '.$cid.' and languages_id = '.$_SESSION['languages_id'].' and type = 0');
//        if($version > 0){
//            $indexName = $indexName.'new_';
//        }
        $indexCacheName = $indexName.$cid.'.html';
		//if($_GET['lang'])  $indexCacheName = $indexName.$_GET['lang'] . $cid.'.html';

		$file_name = $indexCacheName;
		$file_path = DIR_FS_SQL_CACHE.'/htmls/';
        $file_path = $file_path.$_SESSION['languages_code'].'/';
		$file_path_name = $file_path.$file_name;


		if (cacheFactory::get_cached_file_contents($file_path_name, $html)) {
			return $html;
		}

		/*获取一级分类下的二级分类id*/
		$two_arr = fiberstore_category::get_subs_of_root_category($cid);
		$two_size = sizeof($two_arr);
		if($two_size){
            $icon = '';
            $html .='<ul class="primary_nav_ul">';

		  if($two_arr['custom']){
			//有自定义分类
			for($i=0;$i<$two_size-1;$i++){
			  if($i<8){
				$html .='<li><a href="'.reset_url($two_arr[$i]['url']).'"><b>'.$two_arr[$i]['name'].'</b><i class="iconfont icon">&#xf089;</i></a>';
				//获取该二级分类下的三级分类
				$categories_custom_third = zen_get_categories_has_custom_display($two_arr[$i]['cid'],$level=3);
				$len = sizeof($categories_custom_third);
				if($len){
					//有自定义的三级分类
					$html .= '<div class="primary_menu"><dl class="primary_menu_dl">';
					foreach($categories_custom_third as $third){
						$html .= '<dd><a href="'.reset_url($third['url']).'"><b>'.$third['name'].'</b></a></dd>';
					}
					$html .= '</dl></div>';
				}else if($two_arr[$i]['categories_id']){
					//没有自定义的三级分类
					$third_subs = fiberstore_category::get_second_categories($two_arr[$i]['categories_id']);
					if(sizeof($third_subs)){
						$html .= '<div class="primary_menu"><dl class="primary_menu_dl">';
						foreach($third_subs as $third){
							$html .= '<dd><a href="'.zen_href_link(FILENAME_DEFAULT,'&cPath='.$third['id'],'NONSSL').'">'.$third['name'].'</a></dd>';
						}
						$html .= '</dl></div>';
					}
				}
			  }
			}
		  }else{
			//没有自定义分类
			for ($i = 0; $i < $two_size;$i++){
			  if($i<8){
                $id = $two_arr[$i]['id'];
                $name = $two_arr[$i]['name'];
                $subs = $two_arr[$i]['subs'];
				$html .='<li><a href="'.zen_href_link(FILENAME_DEFAULT,'&cPath='.$id,'SSL').'"><b>'.$name.'</b><i class="iconfont icon">&#xf089;</i></a>';

				$result = $db->Execute("select cid from categories_left_display where categories_id=".$id." and language_id = " .(int)$_SESSION['languages_id']);
                $categories_custom_third = zen_get_categories_has_custom_display($result->fields['cid'],$level=3);
				if(count($categories_custom_third)){
					//有自定义的三级分类
                    $html .= '<div class="primary_menu"><dl class="primary_menu_dl">';
					foreach($categories_custom_third as $third){
						$html .= '<dd><a href="'.reset_url($third['url']).'">'.$third['name'].'</a></dd>';
					}
					$html .= '</dl></div>';
				}else if(sizeof($subs)){
                    $html .= '<div class="primary_menu"><dl class="primary_menu_dl">';
					foreach($subs as $sub){
						$html .= '<dd><a href="'.zen_href_link(FILENAME_DEFAULT,'&cPath='.$sub['id'],'NONSSL').'">'.$sub['name'].'</a></dd>';
					}
					$html .= '</dl></div>';
				}
			  }
			}
		  }
            $html .='</ul>';
		}

		cacheFactory::save_caching_file_contents($file_name, $file_path, $html);
		return $html;
	}

    /**
     * @Notes:m端一级分类页面二级分类数据获取
     *
     * @param $cid
     * @return string
     * @auther: Dylan
     * @Date: 2021/1/8
     * @Time: 19:37
     */
    static function show_mobile_index_categories($cid){
        $html = '';

        $file_name = 'category_index_tree_menu_new_m_'.$cid.'.html';
        $file_path = DIR_FS_SQL_CACHE.'/htmls/'.$_SESSION['languages_code'].'/';
        $file_path_name = $file_path.$file_name;

        //if cache file exists, read it and return
        if (cacheFactory::get_cached_file_contents($file_path_name, $html)) {
            return $html;
        }

        /*获取一级分类下的二级分类id*/
        $two_arr = fiberstore_category::get_subs_of_root_category($cid);
        $two_size = sizeof($two_arr);
        if($two_size){
            if($two_arr['custom']){
                //有自定义分类
                for($i=0;$i<$two_size-1;$i++){
                    if($i<8){
                        $html .='<dd><a href="'.reset_url($two_arr[$i]['url']).'">'.$two_arr[$i]['name'].'<i class="iconfont icon">&#xf089;</i></a></dd>';
                    }
                }
            }else{
                //没有自定义分类
                for ($i = 0; $i < $two_size;$i++){
                    if($i<8){
                        $id = $two_arr[$i]['id'];
                        $name = $two_arr[$i]['name'];
                        $html .='<dd><a href="'.zen_href_link(FILENAME_DEFAULT,'&cPath='.$id,'SSL').'">'.$name.'<i class="iconfont icon">&#xf089;</i></a></dd>';
                    }
                }
            }
        }

        cacheFactory::save_caching_file_contents($file_name, $file_path, $html);
        return $html;
    }

      //m端分类目录
   static function show_categories_phone_home(){
        global $db;
        $html = '';
		$phoneHomeName = 'category_tree_phone.html';
		if($_GET['lang'])  $phoneHomeName = 'category_tree_phone_'.$_GET['lang'].'.html';

       $file_name = $phoneHomeName;
       $file_path = DIR_FS_SQL_CACHE.'/htmls/';
       $file_path_name = $file_path.$file_name;

		if (cacheFactory::get_cached_file_contents($file_path_name, $html)) {
			return $html;
		}
        $html.='<div class="header_sidebar_list_one">';
        $one_cate = fs_get_subcategories(0);

        foreach($one_cate as $one_k=>$one_v){
			$categories=fiberstore_category::get_subs_of_root_category($one_v['id']);
			$html.='<div class="header_sidebar_list_one_con">';
            $html.='<a class="header_sidebar_list_one_tit" href="javascript:;" id="one_'.$one_v['id'].'">'.$one_v['name'].'<em class="icon iconfont" >&#xf087;</em></a>';
            $html.='<div class="header_sidebar_list_two_all">';
            //2级有定制
			if($categories['custom']){
				 for ($i = 0,$n =sizeof($categories)-1; $i < $n;$i++){
					 $html.='<div class="header_sidebar_list_two">';
					 $html.='<a href="javascript:;" class="header_sidebar_list_two_tit" > '.$categories[$i]['name'].'<em class="icon iconfont">&#xf087;</em></a>';
					 $html.='<div class="header_sidebar_list_three">';
					 //2级本身有定制的情况下，本身能拿到定制表的cid，通过该cid获取3级定制情况
					 $categories_custom_third = zen_get_categories_has_custom_display($categories[$i]['cid'],$level=3);
					 //3级有定制
					 if($len = sizeof($categories_custom_third)){
						 for($l=0;$l<$len;$l++){
							 $html.='<a href="'.reset_url($categories_custom_third[$l]['url']).'" class="header_sidebar_list_three_tit"><span>'.$categories_custom_third[$l]['name'].'</span></a>';

						 }
					 }elseif($categories[$i]['categories_id']){
					     //3级无定制
						  $subs = fiberstore_category::get_second_categories($categories[$i]['categories_id']);
						  if(sizeof($subs)){
							   foreach ($subs as $ii => $category){
								   $html.='<a href="'.zen_href_link(FILENAME_DEFAULT,'&cPath='.$category['id'],'SSL').'" class="header_sidebar_list_three_tit"><span>'.$category['name'].'</span></a>';
							   }
						  }
					 }
					$html.='</div></div>';
				 }
			}else{
			    //2级没有定制
				for ($i = 0,$n =sizeof($categories); $i < $n;$i++){
					$html.='<div class="header_sidebar_list_two">';
					$html.='<a href="javascript:;" class="header_sidebar_list_two_tit" > '.$categories[$i]['name'].'<em class="icon iconfont">&#xf087;</em></a>';
					$html.='<div class="header_sidebar_list_three">';
                    //2级没有定制的情况下，查找3级的定制
					$result = $db->Execute("select cid from categories_left_display where categories_id=".$categories[$i]['id']." and language_id = " .(int)$_SESSION['languages_id']);
                    $categories_custom_third = zen_get_categories_has_custom_display($result->fields['cid'],$level=3);
                    //有定制
					if($len = sizeof($categories_custom_third)){
						for($l=0;$l<$len;$l++){
							$html .='<dd><a class="recommend_red" href="'. reset_url($categories_custom_third[$l]['url']) .'">'.$categories_custom_third[$l]['name'].'</a></dd>';
						}

					}else{
					    //无定制
						if($categories[$i]['subs']){
							foreach ($categories[$i]['subs'] as $ii => $category){
								 $html.='<a href="'.zen_href_link(FILENAME_DEFAULT,'&cPath='.$category['id'],'SSL').'" class="header_sidebar_list_three_tit"><span>'.$category['name'].'</span></a>';
							}
						}
					}
					$html.='</div></div>';
				}

			}
            $html.='</div></div>';
        }
        $html.='</div>';

        cacheFactory::save_caching_file_contents($file_name, $file_path, $html);
		return $html;
    }

    /**
     * @function m端导航改版,获取一级菜单的all CATEGORIES 部分
     * @date 2019/03/28
     * @author rebirth.ma
     *
     * @return string
     */
   static function show_categories_phone_home_first(){
       $html = '';
       $phoneHomeName = 'category_tree_phone_first.html';
       if($_GET['lang'])  $phoneHomeName = 'category_tree_phone_first_'.$_GET['lang'].'.html';

       $file_name = $phoneHomeName;
       $file_path = DIR_FS_SQL_CACHE.'/htmls/'.$_SESSION['languages_code'] .'/';
       $file_path_name = $file_path.$file_name;

       if (cacheFactory::get_cached_file_contents($file_path_name, $html)) {
           return $html;  //返回缓存
       }
       $html = '<div class="header_sidebar_first_categories">';
       $html .= '<h2 class="header_sidebar_first_categories_tit">'.FS_ALL_CATEGORIES.'</h2>';
       $html .= '<ul class="header_sidebar_first_categories_list">';
       $one_cate = fs_get_subcategories(0);
       foreach($one_cate as $one_k=>$one_v){
           if($one_v['id'] == '74196'){
               continue;
           }
           $html .= '<li cid="'.$one_v['id'].'">';
           $html .= '<div class="header_sidebar_btmLine">';
           $html .= '<span>'.$one_v['name'].'</span>';
           $html .= '<i class="icon iconfont">&#xf089;</i>';
           $html .= '</div>';
           $html .= '</li>';
       }
       $html .= '</ul>';
       $html .= '</div>';
       //存缓存
       cacheFactory::save_caching_file_contents($file_name, $file_path, $html);
       return $html;
   }

    /**
     * @function m端导航改版,获取一级菜单的help_string 部分
     * @date 2019/03/29
     * @author rebirth.ma
     *
     * @return string
     */
    static function show_help_string_phone_home_first(){
        $html = '';
        $phoneHomeName = 'help_string_tree_phone_first.html';
        if($_GET['lang'])  $phoneHomeName = 'help_string_tree_phone_first_'.$_GET['lang'].'.html';

        $file_path = DIR_FS_SQL_CACHE.'/htmls/' .$_SESSION['languages_code'] .'/'; // DIR_FS_SQL_CACHE.'/htmls/'  这个路径错误 清除缓存的地方是 htmls/en/**.html
        $file_name = $phoneHomeName;
        $file_path_name = $file_path.$file_name;
        
        if (cacheFactory::get_cached_file_contents($file_path_name, $html) && $_SERVER['SERVER_NAME'] == "www.fs.com") {
            return $html;  //返回缓存
        }
        $html = '<div class="header_sidebar_first_help">';
        $html .= '<h2 class="header_sidebar_first_categories_tit">'.FS_PH_HELP_SETTING.'</h2>';
        $html .= '<ul class="header_sidebar_first_categories_list">';
        //$one_cate = self::get_help_string_categories();
        require_once('includes/classes/homePageClass.php');
        $home_page = new homePageClass(['language_id' => $_SESSION['languages_id']]);
        $one_cate = $home_page->get_all_classify(2);
        foreach($one_cate as $one_k=>$one_v){
            $html .= '<li class="is_help" cid="'.$one_v['id'].'">';
            $html .= '<div class="header_sidebar_btmLine">';
            $html .= $one_v['title'];
            $html .= '<i class="icon iconfont">&#xf089;</i>';
            $html .= '</div>';
            $html .= '</li>';
        }
        /*$html .= '<li class="is_help" onclick="window.location.href='."'".zen_href_link(FILENAME_CONTACT_US)."'".'">
                <div class="header_sidebar_btmLine">
                '.BOX_INFORMATION_CONTACT.'
                <i class="icon iconfont">&#xf089;</i>
                </div>
                </li>';*/
        $html .= '</ul>';
        $html .= '</div>';
        //存缓存
        cacheFactory::save_caching_file_contents($file_name, $file_path, $html);
        return $html;
    }

    /**
     * @function m端导航改版,获取二三级菜单所有
     * @date 2019/05/22
     * @author rebirth.ma
     *
     * @return string
     */
    static function show_phone_second_third_all_categories(){
        if (in_array($_SESSION['countries_iso_code'], ['us', 'pr'])) {
            if($_SESSION['countries_iso_code'] == 'us'){  //sales tax 只有美国展示
                $phoneHomeName = 'show_phone_second_third_all_categories_e_rate_us.html';
            }else{
                $phoneHomeName = 'show_phone_second_third_all_categories_e_rate_pr.html';
            }
        } else {
            $phoneHomeName = 'show_phone_second_third_all_categories_' . $_GET['lang'] . '.html';
        }
        $file_path = DIR_FS_SQL_CACHE.'/htmls/' .$_SESSION['languages_code'] .'/';
        $file_name = $phoneHomeName;
        $file_path_name = $file_path.$file_name;

        if (cacheFactory::get_cached_file_contents($file_path_name, $html)) {
            return $html;  //返回缓存
        }
//        $html = self::get_all_used_main_menu();
        $html .= '<div class="header_sidebar_second_list_all">';
        $one_cate = fs_get_subcategories(0);
        foreach($one_cate as $one_k=>$one_v){
            if($one_v['id'] == '74196'){
                continue;
            }
            $html .= self::show_categories_phone_home_second($one_v['id'],$one_v['name']);
        }
        $html .= '</div>';

        $html .= '<div class="header_sidebar_second_help_all">';
        /*$one_cate = self::get_help_string_categories();

        foreach($one_cate as $one_k=>$one_v){
            $html .= self::show_help_string_phone_home_second($one_v['new_parent_ids_path'],$one_v['title']);
        }*/
        $html .= self::show_help_string_phone_home_second_new();
        $html .= '</div>';
        //存缓存
        cacheFactory::save_caching_file_contents($file_name, $file_path, $html);
        return $html;
    }


	static function show_categories_for_all_categories(){
		global $db;
		$html = '';

        $file_name= 'all_categores_tree.html';
        $file_path = DIR_FS_SQL_CACHE.'/htmls/';
        $file_path_name = $file_path.$file_name;

		if (cacheFactory::get_cached_file_contents($file_path_name, $html)) {
			return $html;
		}

		/*获取一级分类id*/
		$arr = array();
		$sql= "select c.categories_id as id from " .TABLE_CATEGORIES . " as c left join " .TABLE_CATEGORIES_DESCRIPTION  ." as cd
				on (c.categories_id = cd.categories_id) where c.categories_status = 1
				and cd.language_id = " .(int)$_SESSION['languages_id'] . " and c.parent_id = 0 order by c.sort_order ";

		$result = $db->Execute($sql);
		if ($result->RecordCount()){
			while (!$result->EOF){
				$arr[] = $result->fields['id'];
				$result->MoveNext();
			}
		}
		/*获取一级分类id*/
		$size = sizeof($arr);
		if($size){
			$html = '<div class="n17c_categories_menu"><ul>';
			for($i=0;$i<$size;$i++){
				$html .= '<li><a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$arr[$i],'NONSSL').'"><span>'. zen_get_categories_name((int)$arr[$i]).'</span></a>';
				//一级分类下对应的二级分类
				$categories = fiberstore_category::get_subs_of_root_category((int)$arr[$i]);
				$cate_num = sizeof($categories)-1;
				$html .= '<div class="n17c_categories_menu_more_one">
							<div class="n17c_categories_menu_more_one_main">
								<div class="n17c_categories_menu_more_one_main_font"><dl>';
				if($categories['custom']){
					//有自定义的二级分类
					foreach($categories as $k=>$cate){
						if($k<8){
							$html .= '<dd><a href="'.$cate['url'].'">'.$cate['name'].'</a> </dd>';
						}
					}

				}else{
					for($j=0;$j<$cate_num;$j++){
						if($j<8){
							$html .= '<dd><a href="'.zen_href_link(FILENAME_DEFAULT,'cPath='.(int)$categories[$j]['id'],'NONSSL').'">'.$categories[$j]['name'].'</a> </dd>';
						}
					}
				}
				$html .= '</dl></div></div></div>';
				$html .= '</li>';
			}
			$html .= '</ul></div>';
		}

		cacheFactory::save_caching_file_contents($file_name, $file_path, $html);
		return $html;
	}


    /**
     * @function m端导航改版,获取help_string 部分列表数据
     * @date 2019/03/29
     * @author rebirth.ma
     *
     * @param $current_block_id  //默认获取一级菜单的数据
     * @return array
     */
    private static function get_help_string_categories($current_block_id = '80/82'){
        require_once('includes/classes/home_custom.php');
        $home_custom_model= new homeCustomModel();
        $m_warehouse = '';
        if($_SESSION['languages_code'] == 'fr'){
            if(seattle_warehouse($code = "country_code",$_SESSION['countries_code_21'])){
                $m_warehouse = 1;
            }else{
                $m_warehouse = 2;
            }
        }
        if($_SESSION['languages_code'] == 'ru'){
            if(all_german_warehouse($code="country_code",$_SESSION['countries_code_21'])){
                $m_warehouse = 2;
            }else{
                $m_warehouse = 4;
            }
        }
        $header_is_german_warehouse = all_german_warehouse('country_code',$_SESSION['countries_iso_code']);
        $header_data = $home_custom_model->get_footer_data($header_is_german_warehouse, $m_warehouse,$current_block_id,1);
        return $header_data;
    }

    /**
     * @function m端导航改版，获取公共的MAIN_MENU部分 (js的loading还写了一份)
     * @date 2019/03/29
     * @author rebirth.ma
     *
     * @param $cname
     * @return string
     */
    private static function get_all_used_main_menu($cname){
        $html = '';
//        $html .= '<div class="header_sidebar_second_tofirst" style="cursor:pointer">';

//        $html .= MAIN_MENU;
        $html .= '<h2 class="header_sidebar_second_list_tit">';
        $html .= '<i class="icon iconfont">&#xf090;</i>';
        $html .= '<div class="header_sidebar_second_list_mainTxt">';
        $html .= $cname;
        $html .= '</div>';
        $html .= '</h2>';
//        $html .= '</div>';
        return $html;
    }

    /**
     * @function m端导航改版，获取公共的Networking部分
     * @date 2019/03/29
     * @author rebirth.ma
     *
     * @param $cname
     * @return string
     */
    private static function get_all_used_networking($cname){
        $html = '';
        $html .= '<div class="header_sidebar_second_tosecond" style="cursor:pointer">';
        $html .= self::get_all_used_main_menu($cname);
        $html .= '</div>';
        return $html;
    }

    /**
     * @function m端导航改版，获取公共的view all部分
     * @date 2019/03/29
     * @author rebirth.ma
     *
     * @param  $href     //访问的链接
     * @param $content   //链接里显示的内容  //默认展示view all
     * @return string
     */
    private static function get_all_used_third($href,$content = FS_VIEW_ALL, $is_has_new_proudcts = 0){
        $html = '';
        $html .= '<li>';
        $html .= '<div class="header_sidebar_btmLine">';
        $html .= '<a href="'.$href.'">'.$content;

        if ($is_has_new_proudcts) {
            $html .= '<span class="categories-new">'.NEW_PRODUCTS_TAG.'</span>';;
        }

        $html .= '<i class="icon iconfont ">&#xf089;</i>';
        $html .= '</a>';
        $html .= '</div>';
        $html .= '</li>';
        return $html;
    }

    /**
     * @function m端导航改版,获取二级菜单的all CATEGORIES 部分
     * @date 2019/05/22
     * @author rebirth.ma
     *
     * @param $cid
     * @param $cname
     * @return string
     */
    private static function show_categories_phone_home_second($cid,$cname){
        $html = '';
        $html .= '<div class="header_sidebar_second_list">';
        $html .= '<div class="header_sidebar_second_tofirst" style="cursor:pointer">';
        $html .= self::get_all_used_main_menu($cname);
        $html .= '</div>';
        $html .= '<ul class="header_sidebar_second_categories">';
        $categories=fiberstore_category::get_subs_of_root_category($cid,false);

        $n =sizeof($categories);
        $htmlThird = '';
        if($categories['custom']){
            //有定制
            $n -= 1;
            for ($i = 0; $i < $n;$i++){
                $html .= '<li style="cursor:pointer">';
                $html .= '<div class="header_sidebar_btmLine">';
                $html .= '<i class="icon iconfont ">&#xf089;</i>';
                $html .= $categories[$i]['name'];
                if ($categories[$i]['is_has_new_products'] == 1) {
                    $html .= '<span class="categories-new">'.NEW_PRODUCTS_TAG.'</span>';
                }
                $html .= '</div>';
                $html .= '</li>';
                $htmlThird .= self::show_categories_phone_home_third($categories[$i]['categories_id'], $categories[$i]['name'], $categories[$i]['cid']);
            }
        }else{
            //没有定制
            for ($i = 0; $i < $n;$i++){
                $html .= '<li style="cursor:pointer">';
                $html .= '<div class="header_sidebar_btmLine">';
                $html .= '<i class="icon iconfont ">&#xf089;</i>';
                $html .= $categories[$i]['name'];
                $html .= '</div>';
                $html .= '</li>';
                $htmlThird .= self::show_categories_phone_home_third($categories[$i]['id'],$categories[$i]['name']);
            }
        }
        $html .= '</ul>';
        $html .= '<div class="header_sidebar_third_all">';
        $html .= $htmlThird;
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }


    /**
     * @function m端导航改版,获取三级菜单的all CATEGORIES 部分
     * @date 2019/05/22
     * @author rebirth.ma
     *
     * @param $cid
     * @param $cname
     * @return string
     */
    private static function show_categories_phone_home_third($cid, $cname, $cid_true = 0){
        //由于别人的失误，$cid是categories_left_display中的categories_id，
        global $db;
        $html = '';
        $html .= '<div class="header_sidebar_third">';
        $html .= self::get_all_used_networking($cname);
        $html .= '<ul>';
        $result = $db->Execute("select cid,categories_url as url  from categories_left_display where cid=".intval($cid_true)." and language_id = " .(int)$_SESSION['languages_id']);

        if($result->fields['cid']){
            //二级本身进行了定制
            $url = reset_url($result->fields['url']);
        }else{
            //二级本身没有定制
            $url = zen_href_link(FILENAME_DEFAULT,'&cPath='.$cid,'SSL');
        }
        $html .= self::get_all_used_third($url);

        $categories_custom_third = zen_get_categories_has_custom_display($result->fields['cid'],$level=3);



        if($len = sizeof($categories_custom_third)){
            //有定制
            for($l=0;$l<$len;$l++){
                $html .= self::get_all_used_third(reset_url($categories_custom_third[$l]['url']),$categories_custom_third[$l]['name'], $categories_custom_third[$l]['is_has_new_products']);
            }

        }else{
            //无定制
            $subs = fiberstore_category::get_second_categories($cid);
            if(sizeof($subs)){
                foreach ($subs as $ii => $category){
                    $html .= self::get_all_used_third(zen_href_link(FILENAME_DEFAULT,'&cPath='.$category['id'],'SSL'),$category['name']);
                }
            }
        }
        $html .= '</ul>';
        $html .= '</div>';
        return $html;
    }

    /**
     * @function m端导航改版,获取二级菜单的help_string 部分
     * @date 2019/05/22
     * @author rebirth.ma
     *
     * @param $current_block_id
     * @return string
     */
    private static function show_help_string_phone_home_second($current_block_id,$cname){
        $html = '';
        $html .= '<div class="header_sidebar_second_list">';
        $html .= '<div class="header_sidebar_second_tofirst" style="cursor:pointer">';
        $html .= self::get_all_used_main_menu($cname);
        $html .= '</div>';
        $html .= '<ul>';
        $one_cate = self::get_help_string_categories($current_block_id);
        foreach($one_cate as $one_k=>$one_v){
            $cid = $one_v['url'] ? reset_url($one_v['url']) : 'javascript:void(0);' ;
            $html .= '<li>';
            $html .= '<div class="header_sidebar_btmLine">';
            $html .= '<a href="'.$cid.'">'.$one_v['title'];
            $html .= '<i class="icon iconfont ">&#xf089;</i>';
            $html .= '</a>';
            $html .= '</div>';
            $html .= '</li>';
        }
        if($current_block_id =='80/82/87'){
            //leave feedback
           $html .= '<li><div class="header_sidebar_btmLine">
                        <a href="javascript:;" id="click_feedback">'.FS_FOOTER_FEEDBACK.'</a><i class="icon iconfont ">&#xf089;</i>
                        </div>
                    </li>';
        }
        if ($current_block_id == '80/82/88' && in_array($_SESSION['countries_iso_code'], ['us', 'pr'])){
            if(in_array(strtolower($_SESSION['countries_iso_code']),array('us','pr'))){
                $html .= '<li>';
                $html .= '<div class="header_sidebar_btmLine">';
                $html .= '<a href="'.zen_href_link('e_rate').'">'.FS_ERate_01;
                $html .= '<i class="icon iconfont ">&#xf089;</i>';
                $html .= '</a>';
                $html .= '</div>';
                $html .= '</li>';
            }
           if(strtolower($_SESSION['countries_iso_code']) == 'us') { //美国展示sales tax
               $html .= '<li>';
               $html .= '<div class="header_sidebar_btmLine">';
               $html .= '<a href="'.reset_url('service/sales_tax.html').'">'.FS_HEADER_SALES_TAX;
               $html .= '<i class="icon iconfont ">&#xf089;</i>';
               $html .= '</a>';
               $html .= '</div>';
               $html .= '</li>';
           }
        }
        $html .= '</ul>';
        $html .= '</div>';
        return $html;
    }

    private static function show_help_string_phone_home_second_new(){
        $html = '';
        require_once('includes/classes/homePageClass.php');
        $home_page = new homePageClass(['language_id' => $_SESSION['languages_id']]);
        $one_cate = $home_page->get_header_or_footer_data(2);
        if(sizeof($one_cate)) {
            foreach ($one_cate as $one_k => $one_v) {
                $html .= '<div class="header_sidebar_second_list">';
                $html .= '<div class="header_sidebar_second_tofirst" style="cursor:pointer">';
                $html .= self::get_all_used_main_menu($one_v['title']);
                $html .= '</div>';
                $html .= '<ul>';
                $html .= self::get_second_li($one_v['data']['list']);
                $html .= self::get_second_li($one_v['data']['button']);
                $html .= '</ul>';
                $html .= '</div>';
            }
        }
        return $html;
    }

    private static function get_second_li($data){
        $html = '';
        if(sizeof($data)){
            foreach ($data as $value){
                $html .= '<li>';
                $html .= '<div class="header_sidebar_btmLine">';
                $html .= '<a href="'.$value['url'].'" '.$value['is_click'].'>'.$value['title'];
                $html .= '<i class="icon iconfont ">&#xf089;</i>';
                $html .= '</a>';
                $html .= '</div>';
                $html .= '</li>';
            }
        }
        return $html;
    }
}
