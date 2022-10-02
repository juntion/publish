
<?php
/**
 * 前台首页数据管理
 * Quest add
 */
class homePageClass {

    public $language_id;
    public $site_id;
    public $warehouse = '';
    public $common_where = '';
    public function __construct($arr = array())
    {
        $this->language_id = $arr['language_id'] ? $arr['language_id'] : 1;
        $this->site_id = $arr['site_id'] ? $arr['site_id'] : $arr['language_id'];

        if(empty($arr['warehouse'])) {
            $this->warehouse = get_site_warehouse_str();
        }else{
            $this->warehouse = $arr['warehouse'];
        }

        switch ($_SESSION['languages_code']){
            case 'en':
                $this->site_id = 1;
                $this->language_id = 1;
                break;
            case 'uk':
                $this->site_id = 9;
                $this->language_id = 1;
                break;
            case 'dn':
                $this->site_id = 13;
                $this->language_id = 1;
                break;
            case 'sg':
                $this->site_id = 11;
                $this->language_id = 1;
                break;
            case 'au':
                $this->site_id = 10;
                $this->language_id = 1;
                break;
            case 'es':
                $this->site_id = 2;
                $this->language_id = 2;
                break;
            case 'mx':
                $this->site_id = 12;
                $this->language_id = 2;
                break;
        }

        $this->common_where  .= ' language_id in ('.$this->language_id .') and site_id = '.$this->site_id;
        if($this->warehouse){
            $this->common_where  .= ' and warehouse = '.$this->warehouse;
        }
    }

    public function get_section_type(){
        global $db;
        $sql = 'select * from fs_home_section_type_info 
                where '.$this->common_where.' group by section_type order by sort';
        $result = $db->getAll($sql);
        if(empty($result)){
            $site_id = $this->get_replace_site();
            $result= $db->getAll('select * from fs_home_section_type_info 
                where  language_id in (1) and site_id = '.$site_id.' and warehouse = '.$this->warehouse.' group by section_type order by sort');
        }
        return $result;
    }

    public function index_featured_products_select($section_type = '',$is_mobile = false)
    {
        global $db;
        $info_arr = array();
        $where = $this->common_where;
        if($section_type) {
            $where .= ' and section_type = ' . $section_type;
        }

        $info = $db->getAll('select * from fs_home_featured_products_section where '.$where.' order by sort asc');

        if(empty($info)){
            $info= $db->getAll('select * from fs_home_featured_products_section 
                                where language_id in (1) and site_id = 1 and warehouse = '.$this->warehouse.' order by sort asc');
        }
        if(!$is_mobile){ //pc
            foreach ($info as $key => $val){
                $info_arr[$val['section_type']][] = $val;
            }
        }else{
            $info_arr = $info;
        }
        return $info_arr;
    }

    public function index_featured_products_select_new($section_type = '')
    {
        global $db;
        $info_arr = array();
        $where = $this->common_where;
        if($section_type) {
            $where .= ' and section_type = ' . $section_type;
        }

        $sql = 'select * from fs_home_featured_products_section_new where '.$where.' order by sort asc';
        $info = $db->getAll($sql);

        if(empty($info)){
            $site_id = $this->get_replace_site();
            $info= $db->getAll('select * from fs_home_featured_products_section_new 
                                where language_id in (1) and site_id = '.$site_id.' and warehouse = '.$this->warehouse.' order by sort asc');
        }
        foreach ($info as $key => $val){
            $info_arr[$val['section_type']][] = $val;
        }
        return $info_arr;
    }

    public function indexHomeServicesEnglish($language = 0)
    {
        global $db;
        if (empty($language)) {
            $language = $this->language_id;
        }

        if(in_array($_SESSION['languages_code'],array('en','uk','au','dn','sg'))){
            $language = 1;
        }

        $sql = "select * from fs_home_services where language_id = " . $language . " and status = 1";
        $sql_en = "select * from fs_home_services where language_id = 1 and status = 1";

        if(!empty($this->warehouse)){
            $sql .= " and warehouse = ".$this->warehouse;
        }
        if ($this->site_id) {
            $sql .= " and site_id = ". $this->site_id;
        }

        //英文站数据
        $sql_en .= " and warehouse = 1";
        $sql_en .= " and site_id = 1";

        $sql .= " order by sort asc";
        $sql_en .= " order by sort asc";

        try {
            $result = $db->getAll($sql);
            if(empty($result)){
                $result = $db->getAll($sql_en);
            }
        } catch (\Exception $e) {
            $result = $e->getMessage();
        }

        return $result;
    }

    public function getFiledEnglish($id, $table, $type = true)
    {
        global $db;
        $sql = "select ";
        if ($type) {
            $sql .= "`title`, `content`, `text_link_name`, `link`";
        } else {
            $sql .= "`title`, `link`, `tag_name`, `tag_name_link`, `m_img_path`, `pc_img_path` ";
        }
        $sql .= " from ".$table." where id = " . $id;
        try {
            $result = $db->getAll($sql);
        } catch (\Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    public function indexExploreTheNetwork($language = 0)
    {
        global $db;
        if (empty($language)) {
            $language = $this->language_id;
        }

        if(in_array($_SESSION['languages_code'],array('en','uk','au','dn','sg'))){
            $language = 1;
        }elseif(in_array($_SESSION['languages_code'],array('es','mx'))){
            $language = 2;
        }

        $sql = "select * from fs_home_explore_the_network_new where (article_id > 0 or type = 2) and languages_id = " . $language;
        $sql_en = "select * from fs_home_explore_the_network_new where (article_id > 0 or type = 2) and languages_id = 1";

        if(!empty($this->warehouse)){
            $sql .= ' and warehouse_id = '.$this->warehouse;
        }

        $sql_en .= ' and warehouse_id = 1';

        if ($this->site_id) {
            $sql .= " and site_id = ". $this->site_id;
            $site_id = $this->get_replace_site();
            $sql_en .= " and site_id = ".$site_id;
        }

        $order = ' group by article_id order by sort asc limit 7';
        try {
            $result = $db->getAll($sql.$order);
            if(empty($result)){
                $result = $db->getAll($sql_en.$order);
            }
        } catch (\Exception $e) {
            $result = $e->getMessage();
        }

        return $result;
    }

    public function index_categories_select(){
        global $db;
        $sql = 'select * from fs_home_categories where language_id =' . $this->language_id . ' order by sort asc';
        try {
            $info = $db->getAll($sql);
        } catch (\Exception $e) {
            $info = array();
        }
        return $info;
    }

    // 获取当前站点有哪些仓库
    public function get_site_warehouse($languages_id)
    {
        switch ($languages_id){
            case '1':
                if($_SESSION['languages_code'] == 'sg'){
                    $arr = array(0);
                }else {
                    $arr = array(1, 2, 3, 4);
                }
                break; // 美国 - 美国仓、德国仓、武汉仓、澳大利亚仓
            case '5':
                $arr = array(2);
                break; // 英国、德国 - 德国仓
            case '2': // es 和 mx
                $arr = array(1,2,4);
                break; // 墨西哥 - 美国仓、德国仓、武汉仓
            case '3':
                $arr = array(1,2);
                break; // 法语 - 美国仓、德国仓
            case '4':
                $arr = array(2,4);
                break;   // 俄语 - 德国仓、武汉仓
            case '8':
                $arr = array(4);
                break; // 日语 - 武汉仓
            // 独立站点不显示仓库数据
            case '9':
            case '10':
            case '11':
            case '13':
            default :
                $arr = array(0);
                break;
        }
        return $arr[0];
    }

    public function get_all_classify($type = 1){
        global $db;
        $language = $_SESSION['languages_id'];

        if($_SESSION['languages_code'] == 'mx'){
            $language = 12;
        }elseif($_SESSION['languages_code'] == 'dn'){
            $language = 11;
        }elseif($_SESSION['languages_code'] == 'au'){
            $language = 10;
        }elseif($_SESSION['languages_code'] == 'sg'){
            $language = 13;
        }

        $sql = "select id,title,left_img,left_title,left_content,right_img,right_title,right_content from home_public_head_classify where type = ".$type ;
        $where = " and languages_id = ".$language;
        $en_where = " and languages_id = 1";

        if($type != 1){
            if(!empty($this->warehouse)){
                $where .= " and warehouse_id = ".$this->warehouse;
            }
            $en_where .= " and warehouse_id = 1";
        }

        $order = ' order by location asc limit 5';

        try {
            $result = $db->getAll($sql.$where.$order);
            if(empty($result)){
                $result = $db->getAll($sql.$en_where.$order);
            }
        } catch (\Exception $e) {
            $result = $e->getMessage();
        }

        return $result;
    }

    public function get_classify_list($ids = []){
        global $db;
        $data = [];
        $where = '(status is null or status = 1) and delete_time is null';
        if(sizeof($ids)){
            $ids = implode(',',$ids);
            $where .= ' and classify_id in ('.$ids.')';
        }
        $sql = "select id,classify_id,title,img,url,type,is_button from home_public_head_classify_list where ".$where." order by type asc,rank asc";

        try {
            $result = $db->getAll($sql);
        } catch (\Exception $e) {
            $result = $e->getMessage();
        }

        if(sizeof($result)){
            foreach ($result as $value){
                if(strtolower($value['title']) == 'e-rate' && !in_array($_SESSION['countries_iso_code'],array('us','pr'))){
                    continue;
                }elseif(in_array(strtolower($value['title']),array('sales tax','sale tax')) && !in_array($_SESSION['countries_iso_code'],array('us'))){
                    continue;
                }
                $lowerUrl = strtolower($value['url']);
                if($lowerUrl == 'feedback'){
                    $value['url'] = 'javascript:void(0);';
                    $value['is_click'] = 'id="click_feedback"';
                }elseif(strpos($lowerUrl,'community.fs.com') || strpos($lowerUrl,'youtube')){
                    $value['is_click'] = 'target="_blank"';
                }else{
                    $value['url'] = $value['url'] ? reset_url($value['url']) : '';
                }
                if($value['is_button'] == 1){
                    if($value['title']){
                        $data[$value['classify_id']]['button'][] = $value;
                    }
                }else{
                    if($value['title']){
                        $data[$value['classify_id']]['list'][] = $value;
                    }
                }
            }
        }
        return $data;
    }

    public function get_classify_community_list($ids = []){
        global $db;
        $data = [];
        $where = '1 = 1';
        if(sizeof($ids)){
            $ids = implode(',',$ids);
            $where .= ' and classify_id in ('.$ids.')';
        }
        $sql = "select classify_id,community_id,community_sign,community_title,community_content,community_url,community_video_time from home_public_head_classify_community where ".$where;

        try {
            $result = $db->getAll($sql);
        } catch (\Exception $e) {
            $result = $e->getMessage();
        }

        if(sizeof($result)){
            foreach ($result as $value){
                $data[$value['classify_id']][] = $value;
            }
        }
        return $data;
    }

    public function get_header_or_footer_data($type = 1){
        $return_data = [];
        $class_data = $this->get_all_classify($type);
        if(sizeof($class_data)){
            $ids = array_column($class_data,'id');
            $data = $this->get_classify_list($ids);
            if($type == 1){
                $community_data = $this->get_classify_community_list($ids);
            }
            foreach ($class_data as $key => $val){
                $val['data'] = sizeof($data[$val['id']]) ? $data[$val['id']] : [];
                if($type == 1){
                    $val['community_data'] = sizeof($community_data[$val['id']]) ? $community_data[$val['id']] : [];
                    if($key == 2){
                        array_splice($val['data']['list'],1,0,array(array(
                            'url' => 'mailto:'.get_mail_site_and_country(),
                            'title' => get_mail_site_and_country()
                        )));
                        $tel =  fs_new_get_phone($_SESSION['countries_iso_code']);
                        //意大利电话加上提示
                        if($_SESSION['languages_id'] ==14){
                            $tel .= '<br/>' . FS_IT_TEL_TIP;
                        }
                        array_splice($val['data']['list'],3,0,array(array(
                            'title' => $tel
                        )));
                        if($this->site_id == 1 && $this->warehouse == 4){
                            $val['left_img'] = '/images/head_file/20210318095152_960.jpg';
                        }
                    }
                }else{
                    //底部固定位置邮箱和电话数据
                    /*if($key == 2){
                        $val['data']['list'] = is_array($val['data']['list']) && sizeof($val['data']['list']) ? $val['data']['list'] : [];
                        array_unshift($val['data']['list'],array(
                            'email' => 1,
                            'img' => '/includes/templates/fiberstore/images/new-pc-img/icon_16px_mail.svg',
                            'url' => 'mailto:'.get_mail_site_and_country(),
                            'title' => get_mail_site_and_country(),
                        ),array(
                            'phone' => 1,
                            'img' => '/includes/templates/fiberstore/images/new-pc-img/icon_16px_phonecall_deepgrey.svg',
                            'url' => 'tel:'.fs_new_get_phone($_SESSION['countries_iso_code']),
                            'title' => fs_new_get_phone($_SESSION['countries_iso_code']),
                        ));
                        $val['data']['button'][] = array(
                            'feedback' => 1,
                            'is_button' => 1,
                            'title' => FS_FOOTER_FEEDBACK,
                        );
                    }*/
                }
                $return_data[] = $val;
            }
        }
        return $return_data;
    }

    public function get_replace_site(){
        if($this->warehouse == 2){
            $site_id = 9;
        }elseif($this->warehouse == 3){
            $site_id = 10;
        }elseif($this->warehouse == 5){
            $site_id = 11;
        }else{
            $site_id = 1;
        }
        return $site_id;
    }
}
