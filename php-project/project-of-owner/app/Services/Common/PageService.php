<?php


namespace App\Services\Common;

use App\Services\BaseService;

class PageService extends BaseService
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
    public $list_arr;
    public $use_list;

    public function __construct($total_nums, $per_nums = '15', $list_arr = [], $url_param = [], $use_list = false)
    {
        parent::__construct();

        $this->total_nums = $total_nums;
        $this->page_nums = ceil($total_nums/$per_nums);
        $this->per_nums = $per_nums;
        $this->url_base = $_GET['main_page'];
        $this->url_param = $url_param['url_param'];
        $this->url_param_for_per_num = $url_param['url_param_pre'];

        $current_page = $_GET['page'] ? (int)$_GET['page'] : 1;
        if ($current_page > $this->page_nums) {
            $current_page = $this->page_nums;
        } elseif ($current_page < 1) {
            $current_page = 1;
        }
        $this->current_page = $current_page;
        $this->prev_page =  $this->current_page - 1;
        $this->next_page =  $this->current_page + 1;
        $this->list_arr = sizeof($list_arr) ? $list_arr : array('10', '15', '20');
        $this->use_list = $use_list;
    }

    /**
     * 获取单个A链接的结构
     * @param $page_number
     * @param $is_active
     * @return string
     */
    public function getOneHtml($page_number = '', $is_active = false)
    {
        if ($page_number) {
            if ($is_active) {
                $class = 'choosez';
                $href = 'javascript:;';
                $onclick_str = '';
            } else {
                $href = $this->getLink($page_number);
                $onclick_str = 'onclick="spinloader()"';
                $class = '';
            }
            return '<li class="FS_Newpation_item '.$class.'" '.$onclick_str.'>
                        <a href="'.$href.'" data="'.$page_number.'" >'.$page_number.'</a>
                    </li>';
        } else {
            return '<li class="FS_Newpation_item"><span>...</span></li>';
        }
    }

    /**
     * 获取中间整体a链接的结构
     * @return string
     */
    public function getLinkHtml()
    {
        $display_links_string = '<ul class="FS_Newpation_cont">';
        $page_num = $this->page_nums;
        $page = $this->current_page;
        //初始化数据
        $start = 1;
        $end = $this->page_nums;
        //第一页显示数量
        $showPage = 4;
        //中间显示数量以及偏移量
        $cenPage = 3;
        $pageoffset = ($cenPage - 1)/2;
        if ($page_num > $showPage) {
            //中间循坏输出
            if ($page >= $showPage && $page <= $page_num - $cenPage) {
                $start = $page - $pageoffset;
                $start = (int)$start;
                $end = $page_num >$page + $pageoffset ? $page + $pageoffset :$page_num;
                $end = (int)$end;
            } else {
                //起始循坏
                $start = 1;
                $end = $page_num > $showPage ? $showPage : $page_num;
                $end = (int)$end;
            }
            //结尾循坏
            if ($page > $page_num - $cenPage && $page >= $showPage) {
                $start = $page_num - $cenPage;
                $end = $page_num;
            }
        }
        if ($start > 1) {
            $display_links_string .= $this->getOneHtml(1);
        }
        if ($page >= $showPage && $page_num > $showPage) {
            $display_links_string .= $this->getOneHtml();
        }
        if ($page) {
            for ($i = $start; $i <= $end; $i++) {
                $is_active = $i == $page ? true : false;
                $display_links_string .= $this->getOneHtml($i, $is_active);
            }
        }
        if ($page_num - $cenPage >= $page && $page_num > $end) {
            $display_links_string .= $this->getOneHtml();
        }
        if ($end <= $page_num - 1) {
            $display_links_string .= $this->getOneHtml($page_num);
        }
        $display_links_string .= '</ul>';
        return $display_links_string;
    }
    
    /**
     * 点击跳转页面链接
     * @param $a_page_num: int 第几页
     * @param $is_pre: true为获取右侧下拉点击跳转链接
     * @return string
     */
    public function getLink($a_page_num = '', $is_pre = false)
    {
        $parameters = $is_pre ? $this->url_param_for_per_num : $this->url_param;
        if ($a_page_num) {
            if($this->url_base=='products_support'){
                $symbol = '?';
                if(strpos($parameters,'?')){
                    $symbol = '&';
                }
                $parameters = $is_pre ? $parameters.$symbol.'per_num='.$a_page_num : $parameters.$symbol.'page='.$a_page_num;
            }else{
                $parameters = $is_pre ? $parameters.'&per_num='.$a_page_num : $parameters.'&page='.$a_page_num;
            }
        }
        $lang = $this->session['languages_code'] == 'en' ? '' :
                ($this->session['languages_code'] == 'dn' ? 'de-en' :
                    $this->session['languages_code']);
        //暂不使用zen_href_link方法，拼接链接
        //return zen_href_link($this->url_base, $parameters, 'SSL');
        if($this->url_base=='products_support'){
            return preg_replace("/&(?=&)/", "\\1", $parameters);
        }else {
            return preg_replace("/&(?=&)/", "\\1", $lang . '/index.php?main_page=' . $this->url_base . '&' . $parameters);
        }
    }

    /**
     * 上一页按钮结构
     * @return string
     */
    public function getPreHtml()
    {
        if ($this->current_page == 1) {
            $pre_html = '<a href="javascript:;" class="list_Newpro_page choosez">
                            <i class="iconfont icon">&#xf090;</i>
                         </a>';
        } else {
            $pre_html = '<a href="'.$this->getLink($this->prev_page).'" 
                            class="list_Newpro_page not_first_page" 
                            onclick="spinloader()">
                              <i class="iconfont icon">&#xf090;</i>
                         </a>';
        }
        return $pre_html;
    }

    /**
     * 下一页按钮结构
     * @return string
     */
    public function getNextHtml()
    {
        if ($this->current_page == $this->page_nums) {
            $next_html = '<a href="javascript:;" class="list_Newnext_page is_last_page choosez">
                            <i class="iconfont icon">&#xf089;</i>
                          </a>';
        } else {
            $next_html = '<a href="' . $this->getLink($this->next_page) . '" 
                            class="list_Newnext_page not_first_page" 
                            onclick="spinloader()">
                             <i class="iconfont icon">&#xf089;</i>  
                          </a>';
        }

        return $next_html;
    }

    /**
     * 中间的翻页结构
     * @return string
     */
    public function getCenterHtml()
    {
        $center_html = '<div class="FS_Newpation_box">'
                        .$this->getPreHtml()
                        .$this->getLinkHtml()
                        .$this->getNextHtml()
                    .'</div>';
        return $center_html;
    }

    /**
     * 分页结构右侧下拉框结构，选择每页展示多少条
     * @return string
     */
    public function getControlHtml()
    {
        $list_div = '';
        foreach ($this->list_arr as $v) {
            $list_div .= '<div class="popularity_view_listz1_liMain '
                            .($this->per_nums == $v ? 'choosez' : '').'" data="10" data-url="'
                            .$this->getLink($v, true).'">
                            <p>'.$v.'</p>
                        </div>';
        }
        $perpage_control_html = '<div class="FS_Newpation_enRt">
            <dl class="popularity_view_listz1 page_block">
                <dt class="popularity_view_sortz1 page_block_title">
                    <p>
                        <span class="popularity_view_sortTxt">'.self::trans("FS_COMMON_VIEW").' :</span>
                        '.$this->per_nums.'<span class="iconfont icon"></span>
                    </p>
                </dt>
                <dd class="popularity_view_listz1_li page_block_inner">
                    '.$list_div.'
                </dd>
            </dl>
        </div>';

        $perpage_control_html .= '<script type="text/javascript">
        $(function() {
            $("body").click(function(e) {
				var target = $(e.target);
				if(!target.is(".FS_Newpation_enRt") 
                    && !target.is(".popularity_view_listz1") 
                    && !target.is(".popularity_view_listz1 p") 
                    && !target.is(".popularity_view_sortTxt") 
                    && !target.is(".popularity_view_listz1 p icon") 
                    && !target.is(".popularity_view_listz1_liMain") 
                    && !target.is(".popularity_view_listz1_liMain p")
                ) {
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
                        if ($(this).parents(\'.popularity_view_listz1\')
                                .siblings()
                                .find(\'.popularity_view_sortz1\')
                                .hasClass(\'show\')) {
                            $(this).parents(\'.popularity_view_listz1\')
                                .siblings()
                                .find(\'.popularity_view_sortz1.show\')
                                .removeClass(\'show\')
                                .siblings(\'.popularity_view_listz1_li\').fadeOut(\'fast\');
                        }
                        $(this).parents(\'.popularity_view_listz1\')
                            .addClass(\'choosez1\')
                            .siblings()
                            .removeClass(\'choosez1\');
                    }
                }
        
            })
        })</script>';

        return $perpage_control_html;
    }

    /**
     * 整体分页结构
     * @return string
     */
    public function pageDisplay()
    {
        if ($this->page_nums > 1) {
            $right_html = '';
            if ($this->use_list) {
                $right_html = $this->getControlHtml();
            }
            return
                '<div class="FS_Newpation_en">'
                .$this->getCenterHtml()
                .$right_html
                .'</div>';
        } else {
            return '';
        }
    }
}
