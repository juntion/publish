
<?php
/**
 * 前台数据管理
 * fairy add
 */
class homeCustomModel {
    function __construct() {

    }

    /*
     * 根据对应的版块、对应站点（site_id），对应的语言，对应的仓库，等条件，获取某个版块的数据
     * @para sting $parent_ids_path：父版块字符串（获取父版块的列表），或者当前版块id（适用当前版的数据）。与$is_parent_ids_path一起作用
     * @para int $loop_level：递归循环的层级。可以循环递归改版块下面的所有数据
     * @para string $order：排序
     * @para string $language：语言。不是语种，和网站其他地方不一样
     * @para int $warehouse：仓库id。和运货的仓库id不一样，只是首页这里简单实用
     * @para int $site_id：站点，所有站点唯一
     * @para string $outer_where：附加的条件限制
     * @para string $is_parent_ids_path：$parent_ids_path传递是父版块字符串，还是当前版块id
     * @para string $is_equal：判断版块id的时候，是使用等于，还是like
     * @return array：版块列表
     */
    public function loop_get_block_list($parent_ids_path,$loop_level='',$order='',$language='',$warehouse='',$site_id='',$outer_where='',$is_parent_ids_path=true,$is_equal=true){
        global $db;
        $language = $language?$language:$_SESSION['languages_id'];
        // sg 、uk、au、de-en 调用语种为1的
		if(in_array($_SESSION['languages_code'],array('au','uk','dn'))){
			$language =1;
		}
        $order = $order?$order:'sort';
        if($order == 'sort'){
            $sort_str = ' HCD.sort asc,HC.id asc ';
        }else{
            $sort_str = ' HC.id asc ';
        }
        if($is_equal){
            $symbol = ' = ';
        }else{
            $symbol = ' like ';
        }
        if($is_parent_ids_path){
            $where = ' and HC.parent_ids_path '.$symbol.' "'.$parent_ids_path.'" ';
        }else{
            $where = ' and HC.id '.$symbol.' "'.$parent_ids_path.'" ';
        }
        $where .= 'and HCD.language='.$language.' ';
        if($warehouse){
            $where .= ' and HCD.warehouse="'.$warehouse.'" ';
        }
        if($site_id){
            $where .= ' and HCD.site_id="'.$site_id.'" ';
        }
        $where .= ' and HCD.is_show=1 ';
        $where .= $outer_where;
        // 去重空的数据
        $block = explode('/',$parent_ids_path);
        $block = $block[0];
        if($block==1){  //banner
            //$where .= ' and HCD.url!="" ';
        }elseif($block) {
            $where .= ' and HCD.title!="" ';
        }

        // 前台使用fs_home_custom_des核心，是为了只提取有效数据
        $sql = 'select 
                    HCD.id,
                    HCD.title,
                    HCD.title_british,
                    HCD.title_mobile,
                    HCD.title_mobile_british,
                    HCD.content,
                    HCD.content_british,
                    HCD.img_pc_path,
                    HCD.img_mobile_path,
                    HCD.backimg_pc_path,
                    HCD.backimg_mobile_path,
                    HCD.url,
                    HCD.scene_id,
                    HCD.video_url,
                    HCD.video_url1,
                    HCD.local_video_url,
                    HCD.local_video_poster,
                    HCD.is_local_video,
                    HCD.sort,
                    HCD.products_id,
                    HC.id as home_custom_id,
                    HC.parent_ids_path,
                    HC.name as home_custom_name,
                    HC.css
                from fs_home_custom_des HCD
                LEFT JOIN fs_home_custom HC on HCD.home_custom_id = HC.id 
                where 1 '.$where.' order by '.$sort_str;
        $result = $db->getAll($sql);

        $loop_level--; // 每循环一次前，减一次
        foreach ($result as $key => $val){
            //由于后台不操作banner1所以去掉banner1
            if ($val['home_custom_name'] == 'banner1') {
                unset($result[$key]);
                continue;
            }

            //au、uk、dn使用英式英语
            if($_SESSION['languages_code']=='au' || $_SESSION['languages_code']=='uk' ||  $_SESSION['languages_code'] =='dn' ){
                //后台很多时候直接复制的英语的内容  前台再转义一次 2019.11.8  SQ20191106002
                $title = $val['title_british']?$val['title_british']:$val['title'];
                $content = $val['content_british']?$val['content_british']:$val['content'];
                $title_mobile = $val['title_mobile_british']?$val['title_mobile_british']:$val['title_mobile'];
                $result[$key]['title'] = $title;
                $result[$key]['content'] = swap_american_to_britain($content);
                $result[$key]['title_mobile'] = swap_american_to_britain($title_mobile);
            }

            if(strpos($val['url'],'https://')!==false || strpos($val['url'],'http://')!==false){ //如果带有网址
                $result[$key]['url_str'] = $val['url'];
            }else{
                $result[$key]['url_str'] = reset_url($val['url']);
            }
            if($is_parent_ids_path){
                if($parent_ids_path){
                    $new_parent_ids_path = $parent_ids_path.'/'.$val['home_custom_id'];
                }else{ // 当前分类为最大分类的时候
                    $new_parent_ids_path = $val['home_custom_id'];
                }
            }else{
                $new_parent_ids_path = $parent_ids_path;
            }
            $result[$key]['new_parent_ids_path']  = $new_parent_ids_path;
            if($loop_level){
                $result[$key]['list'] = $this->loop_get_block_list($new_parent_ids_path,$loop_level,$order,$language,$warehouse,$site_id);
            }
        }
        return $result;
    }


    /*
     * 获取首页banner数据
     * @para sting $banner_warehouse_str：仓库banner字符串
     * @return
     */
    public function get_index_banners_data($banner_warehouse_str){
        $current_block_id = 1;
        $warehouse_banner_block_id = $current_block_id.'/57';
        $data = $this->loop_get_block_list($current_block_id.'/%',1,'','','',FS_SITE_UNIQUE_LANGUAGE_ID,'',true,false);
        foreach ($data as $key => $value) {
            if($value['parent_ids_path'] == $warehouse_banner_block_id && $value['home_custom_name'] != 'banner_'.$banner_warehouse_str){
                unset($data[$key]);
            }
        }
        return $data;
    }

    /*
     * 获取 首页banner 数据
     * @return array：数据
     */
    public function get_index_videos_data(){
        $current_block_id = 3;
        $data = $this->loop_get_block_list($current_block_id,1);
        return $data;
    }

    /*
     * 获取 首页tag_img 数据
     * @return array：数据
     */
    public function get_index_tagimg_data(){
        $current_block_id = 317;
        $data = $this->loop_get_block_list($current_block_id,1);
        return $data;
    }

    /*
     * 获取 首页分类 数据
     * @return array：数据
     */
    public function get_index_categories_data(){
        $current_block_id = 2;
        $data = $this->loop_get_block_list($current_block_id,1);
        return $data;
    }

    /*
     * 获取 首页尾部 数据
     * @para bool $is_german_warehouse：是否是德国仓库
     * @para int $warehouse：仓库id
     * @para int $current_block_id：版块id。这个方法的调用可以优化
     * @para int $loop：循环层级。这个方法的调用可以优化
     * @return array：数据
     */
    public function get_footer_data($is_german_warehouse=false,$warehouse='',$current_block_id = '80/82',$loop  = 2){
//        $current_block_id = '80/82';
        $data = $this->loop_get_block_list($current_block_id,$loop,'','',$warehouse,FS_SITE_UNIQUE_LANGUAGE_ID);
        foreach ( $data as $key => $val){
            // 代码临时控制，有的可以转移到数据库中
            if($key == 0){
                if($is_german_warehouse){
                    $footer_data[$key]['list'][] = array(
                        'title' => FS_IMPRINT,
                        'url' => 'imprint.html',
                    );
                }

                $data[$key]['list'][] = array(
                    'title' => FS_FOOTER_FEEDBACK,
                    'url' => '',
                    'id' => 'click_feedback',
                );

            }elseif($key == 3){
				if(FS_SITE_UNIQUE_LANGUAGE_ID==3 && !$is_german_warehouse){
					//fr站且不是欧盟国家时不展示legal_notice.html
					foreach($val['list'] as $key1 => $val1){
						if($val1['url']=='legal_notice.html'){
							unset($data[$key]['list'][$key1]);
						}
					}
				}
            }

            //美国展示消费税入口
            if($val['home_custom_id'] == 88){
                if (in_array(strtolower($_SESSION['countries_iso_code']), ['us', 'pr'])) {
                    $data[$key]['list'][] = array(
                        'title' => FS_ERate_01,  //E-rate 入口调整
                        'url' => zen_href_link('e_rate'),
                        'id' => 'e-rate',
                    );
                }
                if(strtolower($_SESSION['countries_iso_code']) == 'us'){
                    $data[$key]['list'][] = array(
                        'title' => FS_HEADER_SALES_TAX,  //sales Tax 入口
                        'url' => reset_url('service/sales_tax.html'),
                        'id' => 'sales-tax',
                    );
                }
            }
        }
        return $data;
    }

    /*
     * 获取 首页尾部 数据
     * @return array：数据
     */
    public function get_header_nav_data(){
        $all_header_nav = array();
        $current_block_id = '81';
        $header_nav = $this->loop_get_block_list($current_block_id,1,'id');
        $all_header_nav['header_nav1'] = $header_nav[0];
        $all_header_nav['header_nav2'] = $header_nav[1];
        $all_header_nav['header_nav3'] = $header_nav[2];
        $all_header_nav['header_nav4'] = $header_nav[3];
        $all_header_nav['header_nav5'] = $header_nav[4];
        $all_header_nav['header_nav6'] = $header_nav[5];
        $all_header_nav['header_nav7'] = $header_nav[6];

        // 导航1   以下导航下拉内容暂时都查询了 内容都直接在前台写死  后期可考虑优化后台管理后再管理 XQ20200618009
//        $current_block_id = '81/83';
//        $all_header_nav['header_nav1']['list'] = $this->loop_get_block_list($current_block_id,2);
//
//        // 导航2
//        $current_block_id = "81/84";
//        $all_header_nav['header_nav2']['list'] = $this->loop_get_block_list($current_block_id,1);
//
//        // 导航3
//        $current_block_id = "81/85";
//        $all_header_nav['header_nav3']['list'] = $this->loop_get_block_list($current_block_id,3);
//
//        //导航4
//        $current_block_id = "81/86";
//        $all_header_nav['header_nav4']['list'] = $this->loop_get_block_list($current_block_id,1,'','','',FS_SITE_UNIQUE_LANGUAGE_ID);
//
//        //新版solution，这里可以优化
//        $current_block_id = "81/263";
//        $all_header_nav['header_nav5']['list'] = $this->loop_get_block_list($current_block_id,2);
//
//        //导航6
//        $current_block_id = "81/318";
//        $all_header_nav['header_nav6']['list'] = $this->loop_get_block_list($current_block_id,2);
//
//        //导航7
//        $current_block_id = "81/319";
//        $all_header_nav['header_nav7']['list'] = $this->loop_get_block_list($current_block_id,2);

        return $all_header_nav;
    }

    /*
     * 获取 首页solution 数据
     * @return array：数据
     */
    public function get_index_solutions_data(){
        $current_block_id = 5;
        $data = $this->loop_get_block_list($current_block_id,3,'','','','','',false);
        $data = $data[0];
        return $data;
    }

    /*
     * 获取 首页产品 数据
     * @para int $warehouse：仓库id
     * @para int $site_id：站点id
     * @return array：数据
     */
    public function get_index_products_data($warehouse,$site_id=''){
        if(!$warehouse){
            $warehouse = get_site_warehouse_str();
        }
        $current_block_id = 4;
        $data = $this->loop_get_block_list($current_block_id,2,'','',$warehouse,$site_id);
        // 当初为了不多次循环，写了2层。其实写3层更好一点
        foreach ( $data as $key => $val) {
            $first = $list =  array();
            foreach ($val['list'] as $key1 => $val1){
                if($val1['home_custom_name']=='product0'){
                    $first = $val1;
                }else{
                    $list[] = $val1;
                }
            }
            $data[$key]['first'] = $first;
            $data[$key]['second'] = $list;
        }
        return $data;
    }
}

?>