<?php
// 页面
class mypage
{
    public $current_page;
    public $prev_page;
    public $next_page;
    public $page_nums;
    public $total_nums;
    public $per_nums;
    public $url_base;
    public $url_param;
    public $url_param_for_per_num;

    public function __construct($total_nums,$per_nums='15',$url_base='',$url_param=''){
        $this->total_nums = $total_nums;
        $this->page_nums = ceil($total_nums/$per_nums);
        $this->per_nums = $per_nums;
        $this->url_base = $url_base?$url_base:$_GET['main_page'];
        if($url_param){
            $this->url_param = $url_param;
            $this->url_param_for_per_num = $url_param;
        }else{
            $this->url_param = zen_get_all_get_params(array('page','lang'));
            $this->url_param_for_per_num = zen_get_all_get_params(array('page','per_num','lang'));
        }

        $current_page = $_GET['page'] ? (int)$_GET['page'] : 1;
        if($current_page> $this->page_nums){
            $current_page = $this->page_nums;
        }else if($current_page<1){
            $current_page = 1;
        }
        $this->current_page = $current_page;
        $this->prev_page =  $this->current_page - 1;
        $this->next_page =  $this->current_page + 1;
    }

    public function get_a_link($a_page_num=''){
        if($a_page_num){
            return zen_href_link($this->url_base,$this->url_param.'&page='.$a_page_num,'SSL');
        }else{
            return zen_href_link($this->url_base,$this->url_param,'SSL');
        }
    }

    public function get_per_num_link($per_num=''){
        if($per_num){
            return zen_href_link($this->url_base,$this->url_param_for_per_num.'&per_num='.$per_num,'SSL');
        }else{
            return zen_href_link($this->url_base,$this->url_param_for_per_num,'SSL');
        }
    }

    /*
    * 获取prev页的html
    */
    public function get_pre_html(){
        if($this->current_page == 1){
            $pre_html = '<a href="javascript:;" class="list_Newpro_page choosez"><i class="iconfont icon">&#xf090;</i></a>';
        }else{
            $pre_html = '<a href="'.$this->get_a_link($this->prev_page).'" class="list_Newpro_page not_first_page" onclick="spinloader()"><i class="iconfont icon">&#xf090;</i></a>';
        }
        return $pre_html;
    }

    /*
    * 获取next页的html
    */
    public function get_next_html(){
        if ($this->current_page == $this->page_nums) {
            $next_html = '<a href="javascript:;" class="list_Newnext_page is_last_page choosez"><i class="iconfont icon">&#xf089;</i></a>';
        } else {
            $next_html = '<a href="' . $this->get_a_link($this->next_page) . '" class="list_Newnext_page not_first_page" onclick="spinloader()"><i class="iconfont icon">&#xf089;</i></a>';
        }

        return $next_html;
    }

    public function get_one_a_html($page_number='',$is_active=false){
        if($page_number){
            if($is_active){
                $class = 'choosez';
                $href = 'javascript:;';
                $onclick_str = 'onclick="spinloader()"';
            }else{
                $href = $this->get_a_link($page_number);
                $onclick_str = '';
                $class = '';
            }
            return '<li class="FS_Newpation_item '.$class.'" '.$onclick_str.'><a href="'.$href.'" data="'.$page_number.'" >'.$page_number.'</a></li>';
        }else{
            return '<li class="FS_Newpation_item"><span>...</span></li>';
        }
    }

    /*
    * 获取a链接的的html
    */
    public function get_a_html(){
        $display_links_string = '<ul class="FS_Newpation_cont">';
        $page_num = $this->page_nums;
        $page = $this->current_page;
        //初始化数据
        $start = 1;
        $end = $this->page_nums;
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
        if($start >1){
            $display_links_string .= $this->get_one_a_html(1);
        }
        if($page >=$showPage && $page_num>$showPage){
            $display_links_string .= $this->get_one_a_html();
        }
        if($page){
            for($i=$start;$i<$end;$i++){
                $is_active = $i==$page?true:false;
                $display_links_string .= $this->get_one_a_html($i,$is_active);
            }
        }
        if($page_num -$cenPage >= $page && $page_num>6&& $end!=$page_num){
            $display_links_string .= $this->get_one_a_html();
        }
        if($end <= $page_num-1){
            $display_links_string .= $this->get_one_a_html($page_num);
        }
        $display_links_string .= '</ul>';
        return $display_links_string;
    }


    public function get_page_center_html(){
        $right_html = '<div class="FS_Newpation_box">'.$this->get_pre_html().$this->get_a_html().$this->get_next_html().'</div>';
        return $right_html;
    }

    public function get_perpage_control_html(){
        $perpage_control_html = '<div class="FS_Newpation_enRt">
            <dl class="popularity_view_listz1 page_block">
                <dt class="popularity_view_sortz1 page_block_title">
                    <p><span class="popularity_view_sortTxt">'.FS_COMMON_VIEW.' :</span>'.$this->per_nums.'<span class="iconfont icon"></span></p>
                </dt>
                <dd class="popularity_view_listz1_li page_block_inner">
                    <div class="popularity_view_listz1_liMain '.($this->per_nums == 10?'choosez':'').'" data="10" data-url="'.$this->get_per_num_link(10).'">
                        <p>10</p>
                    </div>
                    <div class="popularity_view_listz1_liMain '.($this->per_nums == 15?'choosez':'').'" data="15" data-url="'.$this->get_per_num_link(15).'">
                        <p>15</p>
                    </div>
                    <div class="popularity_view_listz1_liMain '.($this->per_nums == 20?'choosez':'').'" data="20" data-url="'. $this->get_per_num_link(20).'">
                        <p>20</p>
                    </div>
                </dd>
            </dl>
        </div>';

        $perpage_control_html .= '<script type="text/javascript">
        $(function() {
            $("body").click(function(e) {
				var target = $(e.target);
				if(!target.is(".FS_Newpation_enRt") && !target.is(".popularity_view_listz1") && !target.is(".popularity_view_listz1 p") && !target.is(".popularity_view_sortTxt") && !target.is(".popularity_view_listz1 p icon") && !target.is(".popularity_view_listz1_liMain") && !target.is(".popularity_view_listz1_liMain p")) {
					$(".page_block_inner").hide();
					$(".page_block").removeClass("choose1").removeClass("choosez1");
					$(".page_block_title").removeClass("show");
				}
			})
            $(".page_block").click(function(){
                var _this  = $(this);
                if(_this.hasClass("choose1")){
                    
                }else{
                    _this.addClass("choose1");
                    _this.find(".page_block").addClass("show");
                    _this.find(".page_block_inner").show();
                }
            })
            $(".popularity_view_listz1_liMain").click(function(){
                location.href = $(this).attr("data-url");
            });
            $(document).on(\'click\',\'.popularity_view_sortz1\',function(){
                if($(this).parent().hasClass("new_proList_autoDev")){
                    return false;
                }else {
                    if ($(this).hasClass(\'show\')) {
                        $(this).siblings(\'.popularity_view_listz1_li\').fadeOut(\'fast\');
                        $(this).removeClass(\'show\');
                        $(this).parents(\'.popularity_view_listz1\').removeClass(\'choosez1\');
                    }else{
                        $(this).siblings(\'.popularity_view_listz1_li\').fadeIn(\'fast\');
                        $(this).addClass(\'show\');
                        if ($(this).parents(\'.popularity_view_listz1\').siblings().find(\'.popularity_view_sortz1\').hasClass(\'show\')) {
                            $(this).parents(\'.popularity_view_listz1\').siblings().find(\'.popularity_view_sortz1.show\').removeClass(\'show\').siblings(\'.popularity_view_listz1_li\').fadeOut(\'fast\');
                        }
                        $(this).parents(\'.popularity_view_listz1\').addClass(\'choosez1\').siblings().removeClass(\'choosez1\');
                    }
                }
        
            })
        })</script>';

        return $perpage_control_html;
    }

    public function display(){
        if($this->page_nums>1) {
            return '<div class="FS_Newpation_en">' . $this->get_page_center_html() . $this->get_perpage_control_html() . '</div>';
        }else{
            return '';
        }
    }
}
