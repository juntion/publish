<?php
// 评论 start------------
/*
 * 获取一个评论的 指定的 评论
 * @param $comment_id 评论id
 * @param $page 获取评论的个数
 * @return 评论
 * tip 暂时没有用翻页，个人比较少
 */
function get_one_answer_comment_comment ($comment_id,$page='all'){
    $limit = '';
    if($page != 'all'){
        $limit = 'limit '.$page;
    }
    global $db;
    $comments_sql = "SELECT CO.id,CO.content,CO.created_at,CO.from_admin_or_home,CO.created_person,CO.nickname,CO.email
						FROM question_answer_comments CO
						WHERE CO.is_audited=1 AND CO.parent_id=".$comment_id."
						ORDER BY CO.id ASC ".$limit;
    $comments_result = $db->getAll($comments_sql);
    if($comments_result){
        $comments_result = $comments_result[0];
        $comments_result['created_person_sorted'] =  AQ_name_new('answer',$comments_result['from_admin_or_home'],$comments_result['created_person'],$comments_result['email'],$comments_result['nickname']);
        $comments_result['created_at_sorted'] = qa_time_show($comments_result['created_at'],true);
        $comments_result['content_sorted'] = ucfirst(stripslashes($comments_result['content']));
    }

    return $comments_result;
}

/*
 * 获取一个回答的 指定的 评论
 * @param $answer_id 回答id
 * @param $page 获取评论的个数
 * @return 评论
 * tip 暂时没有用翻页，个人比较少
 */
function get_one_answer_comments ($answer_id,$page='all'){
    $limit = '';
    if($page != 'all'){
        $limit = 'limit '.$page;
    }
    global $db;
    $comments_sql = "SELECT CO.id,CO.content,CO.created_at,CO.from_admin_or_home,CO.created_person,CO.nickname,CO.email
						FROM question_answer_comments CO
						WHERE CO.is_audited=1 AND CO.answer_id=".$answer_id." and CO.parent_id=0
						ORDER BY CO.id ASC ".$limit;
    $comments_result = $db->getAll($comments_sql);
    foreach ($comments_result as $comments_key => $comments_val){
        $comments_result[$comments_key]['created_person_sorted'] =  AQ_name_new('answer',$comments_val['from_admin_or_home'],$comments_val['created_person'],$comments_val['email'],$comments_val['nickname']);
        $comments_result[$comments_key]['created_at_sorted'] = qa_time_show($comments_val['created_at'],true);
        $comments_result[$comments_key]['content_sorted'] = ucfirst(stripslashes($comments_val['content']));
    }

    return $comments_result;
}

/*
 * 获取一个问题的评论个数
 * @param $answer_id 问题id
 * @return 评论个数
 */
function get_one_answer_comments_count($answer_id){
    global $db;
    $sql = "SELECT count(id) as count FROM question_answer_comments WHERE is_audited=1 AND answer_id=".$answer_id." ORDER BY created_at ASC ";
    $count = $db->getAll($sql);
    return $count[0]['count'];
}
// 评论 end------------


// 回答 start---------
/*
 * 获取一个问题的 指定个数的 回答
 * @param $question_id 问题id
 * @param $page 页码
 * @param $first_num 第一页显示多少个
 * @param $percent_num 每页显示多少个
 * @return 回答以及评论
 */
function get_one_question_answers($question_id,$page='all',$first_num=FS_PRODUCTS_QA_A_FIRST_NUM,$percent_num=FS_PRODUCTS_QA_A_PERCNET_NUM){
    global $db;
    $limit = '';
    if ($page == 1){
        $limit = 'limit '.$first_num;
    }elseif ($page != 'all'){
        $begin_page = $first_num+($page-2)*$percent_num ;
        $limit = 'limit '.$begin_page.','.$percent_num;
    }

    $answers_sql = "SELECT id,content,created_at,created_person,from_admin_or_home,email,nickname,praise,step,email,files_id
						FROM question_answer_answers 
						WHERE is_audited=1 AND question_id=".$question_id."
						ORDER BY created_at DESC,id DESC ".$limit;
    $answers_result = $db->getAll($answers_sql);
    foreach ($answers_result as $answers_key => $answers_val){
        $answers_result[$answers_key]['id'] = $answers_val['id'];
        $answers_result[$answers_key]['created_person_sorted'] =  AQ_name_new('answer',$answers_val['from_admin_or_home'],$answers_val['created_person'],$answers_val['email'],$answers_val['nickname']);
        $answers_result[$answers_key]['content_sorted'] = ucfirst(stripslashes(stripslashes($answers_val['content'])));
        $answers_result[$answers_key]['created_at_sorted'] = qa_time_show($answers_val['created_at']);
        if(is_give_not_like($answers_val['id'])){
            $answers_result[$answers_key]['step_sorted'] = POPUP_QA_NEW_REPORTED;
        }else{
            $answers_result[$answers_key]['step_sorted'] = POPUP_QA_NEW_REPORT;
        }
    }
    return $answers_result;
}
// 回答 end-------------


// 问题 start--------------
/*
 * 获取一个问题的回答个数
 * @param $question_id 问题id
 * @return 回答个数
 */
function get_one_question_answers_count($question_id){
    global $db;
    $sql = "SELECT count(id) as count FROM question_answer_answers WHERE is_audited=1 AND question_id=".$question_id." ORDER BY created_at ASC ";
    $count = $db->getAll($sql);
    return $count[0]['count'];
}

/*
 * 判断问题是否存在
 * @param $question_id 问题id
 * @return 问题是否存在
 */
function check_question_exist($question_id){
    global $db;
    $questions_sql = 'SELECT count(id) as count FROM question_answer_questions WHERE id='.$question_id;
    $questions_result = $db->getAll($questions_sql);
    $questions_count = $questions_result[0]['count'];
    return $questions_count==0?false:true;
}

/*
 * 获取一个问题
 * @param $question_id 问题id
 * @return 问题
 */
function get_one_question($question_id,$select_type = 0){
    global $db;
    $question_id = (int)$question_id;
    $where = '';
    $order='';
    if($_SESSION['languages_id'] == 1){
        $where = ' and (Q.language_id=1 or Q.language_id=0) ';
    }else{
        //小语种展示当前语种 + 英语  2019.09.11 yoyo   SQ20190902011
        $where .= ' and (Q.language_id =' . $_SESSION['languages_id'] .' or Q.language_id in(0,1))';
    }
    //问题
    if($select_type == 1){
        $questions_sql = 'SELECT Q.id,Q.content,Q.created_at,Q.from_admin_or_home,Q.email,Q.nickname,Q.created_person,Q.products_id,Q.select_type,Q.files_id
	            FROM question_answer_questions Q
	            WHERE Q.id='.$question_id.$where.$order;
    }else{
        $questions_sql = 'SELECT Q.id,Q.content,Q.created_at,Q.from_admin_or_home,Q.email,Q.nickname,Q.created_person,Q.products_id,P.products_image,PD.products_name,Q.select_type,Q.files_id
	            FROM question_answer_questions Q
	            LEFT JOIN products P ON Q.products_id = P.products_id
	            LEFT JOIN '.TABLE_PRODUCTS_DESCRIPTION.' PD ON PD.products_id = P.products_id and  PD.language_id = '.(int)$_SESSION['languages_id'] .'
	            WHERE Q.id='.$question_id.$where.$order;
    }
    $questions_result = $db->getAll($questions_sql);
    if($questions_result){
        $questions_result = $questions_result[0];
        $questions_result['created_person_sorted'] = AQ_name_new('question',$questions_result['from_admin_or_home'],$questions_result['created_person'],$questions_result['email'],$questions_result['nickname']);
        $questions_result['created_at_sorted'] = qa_time_show($questions_result['created_at']);
        $questions_result['content_sorted'] = ucfirst(stripslashes($questions_result['content']));
    }

    return $questions_result;
}

//helun
/*
 * 根据产品获取对应所有问题ID,根据获取的所有问题ID查询到所有的tag_id
 * add helun 2019/7/19
 * @param $products_id 产品id
 * @return string 问题ID
 */
function get_show_questions_id($products_id,$select_type = 0){
    global $db;
    $products_id = (int)$products_id;
    //问题
    $where = '';
    $order='';
    if($_SESSION['languages_id'] == 1){
        $where = ' and (language_id=1 or language_id=0) ';
    }else{
        //小语种展示当前语种 + 英语  2019.09.11 yoyo   SQ20190902011
        $where = ' and (language_id =' . $_SESSION['languages_id'] .' or language_id in(0,1))';
        $order = '(CASE WHEN language_id ="'.$_SESSION['languages_id'].'" THEN 0
                          WHEN language_id = 0 or language_id= 1 THEN 1
                          ELSE 3 END) ASC,';
    }
    //2019-5-23 Yoyo  限制分仓展示
    $warehouse_data = fs_products_warehouse_where();
    $warehouse_where = $warehouse_data['where'];
    if(strpos($warehouse_where,'ru_status')!==false){
        $warehouse_where = ' and cn_status=1'; //Q&A暂时未开启ru仓
    }
    $where .= $warehouse_where;
    $questions_sql = 'SELECT id
	            FROM question_answer_questions
	            WHERE is_audited=1 AND products_id='.$products_id. ' AND select_type= '.$select_type.$where.
        ' ORDER BY '.$order.'created_at desc ';
    $questions_arr = $db->getAll($questions_sql);
    $questions_id = '';
    if(sizeof($questions_arr)){
        foreach($questions_arr as $q_id){
            $questions_id .= $q_id['id'].',';
        }
    }
    $questions_id = rtrim($questions_id,',');

    return $questions_id;
}

//搜索关键字有结果展示结构
function get_questions_show_tag($products_id, $current_count, $keyname, $type){
    global $db;
    $qa_tag_html = '';
    if($products_id){
        //返回初始化需要的总页面
        $customer_questions_count = get_one_product_questions_count($products_id);
        if($customer_questions_count > FS_PRODUCTS_QA_Q_PERCNET_NUM){
            $qa_page_num = ceil(($customer_questions_count/10));
        }
        //当前搜索关键字总页面
        $page_num = ceil(($current_count / 10));
        if($page_num >1){
            $page_end = '1-10';
            $page_count_html = str_replace('PAGEEND',$page_end,FS_PRODUCTS_QA_04);
            $page_count_html = str_replace('PAGENUM',$current_count,$page_count_html);
        }else{
            $page_end = '1-'.$current_count;
            $page_count_html = str_replace('PAGEEND',$page_end,FS_PRODUCTS_QA_04);
            $page_count_html = str_replace('PAGENUM',$current_count,$page_count_html);
        }
        $page_num = $page_num ? :1;
        if ($type == 'pc') {
            $qa_tag_html .= '<p class="search_result_p_t10">';
            if($_SESSION['languages_code'] !='jp'){
                $qa_tag_html .= '<span id="tag_page_count">'.$page_count_html.' </span>"<span id="qa_tag_name">'.$keyname.'</span>".';
            }else{
                $qa_tag_html .= '"<span id="qa_tag_name">'.$keyname.'</span>"<span id="tag_page_count">'.$page_count_html.' </span>';
            }
            $qa_tag_html .= ' <span class="span_tag_clear" onclick="show_more_questions(1,6,'.$qa_page_num .')">'.FS_PRODUCTS_QA_03.' </span></p>';
        } else {
            $qa_tag_html .= '<div class="header-qaSerch-resultTxt">'
                .FS_PRODUCTS_QA_01.' '.POPUP_QA_NEW_ASK.
                '</div>';
            $qa_tag_html .= '<div class="header-qaSerch-resultTxt01">';
            if($_SESSION['languages_code'] !='jp'){
                $qa_tag_html .= '<span id="tag_page_count">'.$page_count_html.' </span>"<span id="qa_tag_name">'.$keyname.'</span>".';
            }else{
                $qa_tag_html .= '"<span id="qa_tag_name">'.$keyname.'</span>"<span id="tag_page_count">'.$page_count_html.' </span>';
            }
            $qa_tag_html .= '<span class="span_tag_clear" onclick="show_more_questions(1,6,'.$qa_page_num .')">'.FS_PRODUCTS_QA_03.' </span></p>';
            $qa_tag_html .= '</div>';
        }

    }     
    return $qa_tag_html;
}


//搜索关键字无结果展示结构
function get_questions_tag($products_id='', $type){
    global $db;
    $qa_tag_html = '';
    if ($type == 'pc') {
        if($products_id){
            $customer_questions_count = get_one_product_questions_count($products_id);
            if($customer_questions_count > FS_PRODUCTS_QA_Q_PERCNET_NUM){
                $qa_page_num = ceil(($customer_questions_count/10));
            }
            $qa_page_num = $qa_page_num ? :1;
            $questions_id = get_show_questions_id($products_id);
            $questions_sql = 'SELECT tag_id FROM question_answer_tag_relate WHERE qa_id in(' .$questions_id. ') GROUP BY tag_id';
            $tag_id_arr = $db->getAll($questions_sql);
            $tag_id = '';
            foreach($tag_id_arr as $val){
                $tag_id .= $val['tag_id'].',';
            }
            $tag_id = rtrim($tag_id,',');
            if($tag_id != ''){
                if($_SESSION['languages_id'] == 1){
                    $questions_tag_sql = 'SELECT id,tag_name FROM question_answer_tag WHERE id in(' .$tag_id. ') and language_id = 1';
                }else{
                    $questions_tag_sql = 'SELECT id,tag_name FROM question_answer_tag WHERE id in(' .$tag_id. ') and (language_id=1 or language_id='.$_SESSION['languages_id'].')';
                }

                $qa_tag_arr = $db->getAll($questions_tag_sql);
                if(sizeof($qa_tag_arr)){
                    foreach($qa_tag_arr as $value){
                        $qa_tag_html .= '<a class="alone_question_a quest_true" href="javascript:;" onclick="select_qa_tag(this,'.$value['id'].')">'.$value['tag_name'].'</a>';
                    }
                }
            }
            $qa_tag_html .= '<p class="search_result_p_t10">';
            if($_SESSION['languages_code'] !='jp'){
                $qa_tag_html .= '<span id="tag_page_count">'.FS_PRODUCTS_QA_02.' </span>"<span id="qa_tag_name"></span>". ';
            }else{
                $qa_tag_html .= '"<span id="qa_tag_name"></span>"<span id="tag_page_count">'.FS_PRODUCTS_QA_02.' </span>';
            }
            $qa_tag_html .= '<span class="span_tag_clear" onclick="show_more_questions(1,6,'.$qa_page_num.')">'.FS_PRODUCTS_QA_03.' </span></p>';
        }
    } else {
        $qa_tag_html .= '
	                <div class="qaSerch-emptyBox-m">
	                	<div class="qaSerch-emptyBox-mTa">
	                		<div class="qaSerch-emptyBox-mTacell">
	                			<img src="'.HTTPS_IMAGE_SERVER.'includes/templates/fiberstore/images/QA-Search-emptyIcon.png">
	                			<p>
	                				'.FS_PRODUCTS_QA_08.' "<span id="qa_tag_name"></span>".<br/>
	                				'.FS_PRODUCTS_QA_09.'<br/>
	                				'.POPUP_QA_NEW_ASK.'
	                			</p>
	                		</div>
	                	</div>
	                </div>';
    }
    return $qa_tag_html;
}

//pc QA tag 2020.6.4 pico
function get_questions_tag_only($products_id='',$page_num,$tag=0,$select_type = 0){
    global $db;
        $qa_tag_html = '';
        if($products_id){
            $questions_id = get_show_questions_id($products_id,$select_type);
            $questions_sql = 'SELECT tag_id FROM question_answer_tag_relate WHERE qa_id in(' .$questions_id. ') GROUP BY tag_id';
            $tag_id_arr = $db->getAll($questions_sql);
            $tag_id = '';
            if(sizeof($tag_id_arr)){
                foreach($tag_id_arr as $val){
                    $tag_id .= $val['tag_id'].',';
                }
            }
            $tag_id = rtrim($tag_id,',');
            if($tag_id != ''){
                if($_SESSION['languages_id'] == 1){
                    $questions_tag_sql = 'SELECT id,tag_name FROM question_answer_tag WHERE id in(' .$tag_id. ') and language_id = 1';
                }else{
                    $questions_tag_sql = 'SELECT id,tag_name FROM question_answer_tag WHERE id in(' .$tag_id. ') and (language_id=1 or language_id='.$_SESSION['languages_id'].')';
                }

                $qa_tag_arr = $db->getAll($questions_tag_sql);
                if(sizeof($qa_tag_arr) > 0){
                    foreach($qa_tag_arr as $k => $val){
                        $questions = product_get_one_product_questions($products_id,'all',$val['id'],'','',$select_type);
                        $current_count = count($questions);
                        $qa_tag_arr[$k]['order'] = $current_count;
                    }
                    $names = array_column($qa_tag_arr, 'tag_name');
                    $order = array_column($qa_tag_arr, 'order');
                    array_multisort($order,SORT_DESC , $names,SORT_ASC , $qa_tag_arr);
                    $ids = array_slice(array_column($qa_tag_arr, 'id'),5);
                    $qa_tag_html .= '<div class="result_classification_main">';
                    $all_style = $tag > 0 ? '' : 'pointselect';
                    $qa_tag_html .= '<a class="alone_question_a quest_true '.$all_style.'" href="javascript:;" onclick="select_qa_tag(this,1,'.$page_num.',1)">'.FS_SALES_ALL.'</a>';
                    $hide_flag = false;
                    foreach($qa_tag_arr as $k => $value){
                        if ($k >= 25){
                            break;
                        }
                        $class = '';
                        if($value['id'] == $tag){
                            $class = ' pointselect';
                        }
                        if ($k >= 7) {
                            if(in_array($tag,$ids)){
                                $hide_flag = true;
                            }
                            if ($k == 7) {
                                $style = $hide_flag ? 'style="display: none;"' : '';
                                $qa_tag_html .= '<a class="alone_question_a quest_true qa_more" href="javascript:;" onclick="show_QA()" '.$style.'>'.FS_COMMON_MORE.' &#43;</a>';
                            }
                            $style = $hide_flag ? 'QA_show_tag' : 'QA_none';
                            $qa_tag_html .= '<a class="alone_question_a quest_true '.$style.$class.'" href="javascript:;" onclick="select_qa_tag(this,'.$value['id'].','.$page_num.')">'.$value['tag_name'].' ('.$value['order'].')</a>';
                        }else {
                            $qa_tag_html .= '<a class="alone_question_a quest_true'.$class.'" href="javascript:;" onclick="select_qa_tag(this,'.$value['id'].','.$page_num.')">'.$value['tag_name'].' ('.$value['order'].')</a>';
                        }
                    }
                    $style = ($tag > 0 && $hide_flag) ? '' : 'style="display: none;"';
                    $less = in_array($_SESSION['languages_code'],array('de','fr', 'es', 'mx')) ? FS_COMMON_LESS : FS_COMMON_MORE;
                    $qa_tag_html .= '<a class="alone_question_a quest_true qa_hide" href="javascript:;" onclick="hide_QA()" '.$style.'>'.$less.' &#45;</a>';
                    $qa_tag_html .= '</div>';
                }
            }
        }
    $qa_tag_html = content_preg_mtp($qa_tag_html);
    return $qa_tag_html;
}

//获取问题标签对应的问题ID
function get_questions_id($tag_id,$products_id,$select_type = 0){
    global $db;
    $qa_id = get_show_questions_id($products_id,$select_type);
    $questions_sql = 'SELECT qa_id FROM question_answer_tag_relate WHERE tag_id ='.$tag_id.' and qa_id in(' .$qa_id. ')';
    $questions_id = $db->getAll($questions_sql);
    return $questions_id;
}


/*
 * qa 公共调用分页
 * add yoyo
 * update helun 2019/7/19
 * @param $current_count 查询结果条数
 * @param $page_num 总页数
 * @param $page 第几页
 * @return string 分页dom
 */
function get_qa_ajax_page($current_count,$page_num,$page=1,$tag_id=0,$pid=0,$select_type = 0){
    //var_dump(isMobile());
    $page_content = '<div class="qa_more">
                            <a href="'.zen_href_link('qa_list', 'pid='.$pid.'&type='.$select_type, 'SSL').'" id="show_more_questions"><span>'.FS_QA_SHOW_ALL_QUESTIONS.'</span><span class="iconfont icon">&#xf089;</span></a>
                        </div>';
    return $page_content;
    if ($current_count>0){
        $start = 1;
        $end = $page_num;
        //第一页显示数量
        $showPage = 5;
        //中间显示数量以及偏移量
        $cenPage = 3;
        $pageoffset = ($cenPage -1)/2;
        //结尾显示数量
        $endPage = 4;
        if($page_num >= $showPage){
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
        /*2019.06.25  Yoyo
         * PC端下一页的样式改动  与列表页面一致
         *
         * */
        if (!isMobile()) {
            $page_content .= '<div class="FS_Newpation_en" id="QA_page_num"><div class="FS_Newpation_box">';
            if ($page && $page != 1)
                $page_content .= '<a  href="javascript:;" class="list_Newpro_page not_first_page" onclick="show_more_questions(' . ($page - 1) . ',3,' . $page_num . ','.$tag_id.')" data = "' . $prev_page . '"><icon class="icon iconfont">&#xf090;</icon></a>';
            else $page_content .= '<a href="javascript:;" class="list_Newpro_page choosez"><icon class="icon iconfont">&#xf090;</icon></a>';
            $page_content .= '<ul class="FS_Newpation_cont">';
            if ($start > 1) {
                $page_content .= '<li class="FS_Newpation_item"><a href="javascript:;" onclick="show_more_questions(1,3,' . $page_num . ','.$tag_id.')" class="the_page" data="1">1</a></li>';
            }
            if ($page >= $showPage && $page_num > $showPage) {
                $page_content .= '<li class="FS_Newpation_item omit">
                       <span href="javascript:;" class="the_page">...</span>
                   </li>';
            }
            if ($page) {
                for ($i = $start; $i <= $end; $i++) {
                    if ($i == $page) {
                        $page_content .= '<li class="FS_Newpation_item choosez"> <a href="javascript:;" onclick="show_more_questions(' . $i . ',3,' . $page_num . ','.$tag_id.')" class="the_page" data = "' . $i . '">' . $i . '</a></li>';
                    } else {
                        $page_content .= '<li class="FS_Newpation_item">
                <a href="javascript:;" onclick="show_more_questions(' . $i . ',3,' . $page_num . ','.$tag_id.')"
                          class="the_page" data = "' . $i . '">' . $i . '</a></li>';
                    }
                }
            }

            if ($page_num - $cenPage >= $page && $page_num > 6 && $end != $page_num) {
                $page_content .= '<li class="FS_Newpation_item omit">
                       <span href="javascript:;" class="the_page">...</span>
                   </li>';
            }
            if ($end <= $page_num - 1) {
                $page_content .= '<li class="FS_Newpation_item">
                <a href="javascript:;" class="the_page" onclick="show_more_questions(' . $page_num . ',3,' . $page_num . ','.$tag_id.')" data = "' . $page_num . '">' . $page_num . '</a></li>';
            }
            $page_content .= '</ul>';
            if (($page < $page_num) && ($page_num != 1))
                $page_content .= '<a href="javascript:;" class="list_Newnext_page not_first_page" onclick="show_more_questions(' . ($page + 1) . ',3,' . $page_num . ','.$tag_id.')"><icon class="icon iconfont">&#xf089;</icon></a>';
            else $page_content .= '<a href="javascript:;" class="list_Newnext_page choosez is_last_page" data="' . $next_page . '"><icon class="icon iconfont">&#xf089;</icon></a>';
            $page_content .= '</div></div>';
        }else{
            $page_content .= '<div class="FS_Newpation_box QA_page_num" id="QA_page_num">';
            if ($page && $page != 1)
                $page_content .= '<a  href="javascript:;" class="list_Newpro_page not_first_page" onclick="show_more_questions(' . ($page - 1) . ',3,' . $page_num . ',1)" data = "' . $prev_page . '"><icon class="icon iconfont">&#xf090;</icon></a>';
            else $page_content .= '<a href="javascript:;" class="list_Newpro_page choosez"><icon class="icon iconfont">&#xf090;</icon></a>';
            $page_content .= '<ul class="FS_Newpation_cont">';
            if ($start > 1) {
                $page_content .= '<li class="FS_Newpation_item"><a href="javascript:;" onclick="show_more_questions(1,3,' . $page_num . ',1)" class="the_page" data="1">1</a></li>';
            }
            if ($page >= $showPage && $page_num > $showPage) {
                $page_content .= '<li class="FS_Newpation_item omit">
                       <span href="javascript:;" class="the_page">...</span>
                   </li>';
            }
            if ($page) {
                for ($i = $start; $i <= $end; $i++) {
                    if ($i == $page) {
                        $page_content .= '<li class="FS_Newpation_item choosez"> <a href="javascript:;" onclick="show_more_questions(' . $i . ',3,' . $page_num . ',1)" class="the_page" data = "' . $i . '">' . $i . '</a></li>';
                    } else {
                        $page_content .= '<li class="FS_Newpation_item">
                <a href="javascript:;" onclick="show_more_questions(' . $i . ',3,' . $page_num . ',1)"
                          class="the_page" data = "' . $i . '">' . $i . '</a></li>';
                    }
                }
            }

            if ($page_num - $cenPage >= $page && $page_num > 6 && $end != $page_num) {
                $page_content .= '<li class="FS_Newpation_item omit">
                       <span href="javascript:;" class="the_page">...</span>
                   </li>';
            }
            if ($end <= $page_num - 1) {
                $page_content .= '<li class="FS_Newpation_item">
                <a href="javascript:;" class="the_page" onclick="show_more_questions(' . $page_num . ',3,' . $page_num . ',1)" data = "' . $page_num . '">' . $page_num . '</a></li>';
            }
            $page_content .= '</ul>';
            if (($page < $page_num) && ($page_num != 1))
                $page_content .= '<a href="javascript:;" class="list_Newnext_page not_first_page" onclick="show_more_questions(' . ($page + 1) . ',3,' . $page_num . ',1)"> <icon class="icon iconfont">&#xf089;</icon></a>';
            else $page_content .= '<a href="javascript:;" class="list_Newnext_page is_last_page choosez " data="' . $next_page . '"><icon class="icon iconfont">&#xf089;</icon></a>';
            $page_content .= '</div>';
        }
    }
    return $page_content;
}
// tag-helun end

/*
 * 获取一个产品的问题个数
 * @param $products_id 产品id
 * @param $tag_id标签id
 * @param $keyname 关键字
 * @return 问题个数
 */
function get_one_product_questions_count($products_id,$tag_id = 0,$keyname='',$select_type = 0){
    global $db;
    if($_SESSION['languages_id'] == 1) {
        $where = ' and (language_id=1 or language_id=0) ';
    }else{
        //小语种展示当前语种 + 英语  2019.09.11 yoyo   SQ20190902011
        $where = ' and (language_id =' . $_SESSION['languages_id'] .' or language_id in(0,1))';
    }
    //2019-5-23 Yoyo  限制分仓展示
    $warehouse_data = fs_products_warehouse_where();
    $warehouse_where = $warehouse_data['where'];
    if(strpos($warehouse_where,'ru_status')!==false){
        $warehouse_where = ' and cn_status=1'; //Q&A暂时未开启ru仓
    }
    $where .= $warehouse_where;
     //2019/7/19 helun 关联标签
     if($tag_id != 0){
        $get_questions_id = get_questions_id($tag_id,$products_id,$select_type);
        $qa_id = '';
        if(sizeof($get_questions_id)){
            foreach($get_questions_id as $val){
                $qa_id .= $val['qa_id'].',';
            }
            $qa_id = rtrim($qa_id,',');
            if($qa_id != ''){
                $tag_where = ' and id in ('.$qa_id.')';
                $where .= $tag_where;
            }
        }
    }
    if($keyname != ''){
        $like = ' content like "%'.$keyname.'%" AND';
    }
    $sql = "SELECT count(id) as count FROM question_answer_questions WHERE ".$like." is_audited=1 AND products_id=".$products_id.' AND select_type='.$select_type.$where." ORDER BY created_at ASC ";
    $count = $db->getAll($sql);
    return $count[0]['count'];
}

/*
 * 获取一个产品的问题
 * @param $products_id 产品id
 * @param $page 页码
 * @param $first_num 第一页显示多少个
 * @param $percent_num 每页显示多少个
 * @param $tag_id 问题关联的标签id add->helun
 * @return 问题
 */
function get_one_product_questions($products_id,$page='all',$first_num=FS_PRODUCTS_QA_Q_FIRST_NUM,$percent_num=FS_PRODUCTS_QA_Q_PERCNET_NUM,$tag_id=0,$keyname='',$select_type = 0){
    global $db;
    $products_id = (int)$products_id;
    $limit = '';
    if ($page == 1){
        $limit = 'limit '.$first_num;
    }elseif ($page != 'all' ){
        $begin_page = $percent_num+($page-2)*$percent_num ;
        $begin_page = $begin_page > 0 ? $begin_page : 0;
        $limit = 'limit '.$begin_page.','.$percent_num;
    }

    //问题
    $where = '';
    $order='';
    if($_SESSION['languages_id'] == 1){
        $where = ' and (language_id=1 or language_id=0) ';
    }else{
        //小语种展示当前语种 + 英语  2019.09.11 yoyo   SQ20190902011
        $where .= ' and (language_id =' . $_SESSION['languages_id'] .' or language_id in(0,1))';
        $order = '(CASE WHEN language_id ="'.$_SESSION['languages_id'].'" THEN 0
                          WHEN language_id = 0 or language_id= 1 THEN 1
                          ELSE 3 END) ASC,';
    }
    //2019-5-23 Yoyo  限制分仓展示
    $warehouse_data = fs_products_warehouse_where();
    $warehouse_where = $warehouse_data['where'];
    if(strpos($warehouse_where,'ru_status')!==false){
        $warehouse_where = ' and cn_status=1'; //Q&A暂时未开启ru仓
    }
    $where .= $warehouse_where;
    //2019/7/19 helun 关联标签
    if($tag_id != 0){
        $get_questions_id = get_questions_id($tag_id,$products_id,$select_type);
        $qa_id = '';
        if(sizeof($get_questions_id)){
            foreach($get_questions_id as $val){
                $qa_id .= $val['qa_id'].',';
            }
            $qa_id = rtrim($qa_id,',');
            if($qa_id != ''){
                $tag_where = ' and id in ('.$qa_id.')';
                $where .= $tag_where;
            }
        }
    }
    if($keyname != ''){
        $like = ' content like "%'.$keyname.'%" AND';
    }
    $questions_sql = 'SELECT id,content,created_at,from_admin_or_home,email,nickname,created_person,select_type,files_id
	            FROM question_answer_questions
	            WHERE '.$like.' is_audited=1 AND products_id= '.$products_id. ' AND select_type ='.$select_type .$where.
        ' ORDER BY is_top desc,'.$order.'created_at desc '.$limit;
    $questions_result = $db->getAll($questions_sql);

    if(sizeof($questions_result)){
        foreach ($questions_result as $key => $val){
            $questions_result[$key]['created_person_sorted'] = AQ_name_new('question',$val['from_admin_or_home'],$val['created_person'],$val['email'],$val['nickname']);
            $questions_result[$key]['created_at_sorted'] = qa_time_show($val['created_at']);
            $questions_result[$key]['content_sorted'] = ucfirst(stripslashes($val['content']));
        }
    }
    return $questions_result;
}
// 问题 end--------------


// 产品详情页面 start-----------------
// 获取一个产品的问题（默认和异步通用）
function product_get_one_product_questions($products_id,$page=1,$tag_id=0,$keyname='',$num=FS_PRODUCTS_QA_Q_FIRST_NUM,$select_type = 0){
    $questions = get_one_product_questions($products_id,$page,$num,FS_PRODUCTS_QA_Q_PERCNET_NUM,$tag_id,$keyname,$select_type);
    if(sizeof($questions)){
        foreach ( $questions as $questions_key =>$questions_val ){
            $questions[$questions_key]['answers'] = get_one_question_answers($questions_val['id'],1,FS_PRODUCTS_QA_A1_FIRST_NUM);
//            $questions[$questions_key]['created_person_sorted'] = hide_name($questions_val['created_person_sorted']);
        }
    }
    return $questions;
}

// 产品详情页面 展示问题列表html（默认和异步通用）$type为3点击分页全部展示
function product_questions_show($question, $type = "")
{
    $return_content = $question_by = '';

    foreach ($question as $key => $val){
        if(empty($type)){
            if (isMobile() && $key > 0) {
                $is_hide = 'style="display:none"';
            }
            if (!isMobile() && $key > 0) {
                $is_hide = 'style="display:none"';
            }
        }else{
            $is_hide = '';
        }
        if($_SESSION['languages_code'] !='jp') {
            if ($val['created_person_sorted']) {
                $question_by =  $val['created_person_sorted'];
            }
            $question_by .= $val['created_at_sorted'];
        }else{
            $question_by = $val['created_at_sorted'].$val['created_person_sorted'] .POPUP_QA_CREATED_BY_JP;
        }
        $files_html = $val['files_id'] != '' ? get_files_html($val['files_id']) : '';
        $return_content .= '<li class="li_show" '.$is_hide.'>
                        <div class="pro17_Q_tit qa_result">
                            <div class="qa_container">
                                <dl class="qa_result_dl">
                                    <dt>
                                        <div class="qa_result_dlFlex">
                                            <span>'.FS_PRODUCTS_QA_Q.'</span>
                                            <p>
                                                <a class="qa_a_hover" href="'.reset_url('customer_qa.html?qid='.$val['id'].'&type='.$val['select_type']).'">'.$val['content_sorted'].'</a>
                                                <strong class="pro_hiden01">'.$question_by.'</strong>
                                            </p>
                                         </div>
                                         '.$files_html;
        if (isset($val['answers']) && count($val['answers']) > 0) {

            $return_content .= '</dt>';
            $return_content .= '<!-- answer block -->';
            $return_content .= '<div class="answer_block">';
            $return_content .= product_answers_show($val['answers'],'ajax_more', $val['id'], $val['select_type']);
            $return_content .= '</div>';
        }  else {
            $data_href = reset_url('customer_qa.html?qid='.$val['id'].'&type='.$val['select_type']);
            $return_content .= '<p class="qa_prompt">'.str_replace('###DATA-HREF###', $data_href, FS_QA_ANSWER_QUESTION).'</p>';
            $return_content .= '</dt>';
        }


        $return_content .= '
                    </dl>
                </div>
            </div>';
        $return_content .= '</li>';
    }
    $return_content = content_preg_mtp($return_content);
    return $return_content;
}

// 产品详情页面 展示回答列表html（默认和异步通用）
/*
 * 2019.06.25  Yoyo
 * QA 结构微调
 * */
function product_answers_show($answers, $type, $question_id, $select_type = 0)
{
    $return_content = '';
    $data_href = reset_url('customer_qa.html?qid=' . $question_id . '&type=' . $select_type);

    $all_answers_count = get_one_question_answers_count($question_id);
    $answers_count = count($answers);


    //获取的只是一个question的部分answers
    foreach($answers as $answers_key => $answers_val){
        $class = $answers_key == 0 ? '' : 'false';
        //回答内容
        $return_content .= '<dd class="' . $class . '">';
        $return_content .= '<div class="qa_overflow ">';
        $return_content .= '<div class="qa_result_ddFlex">';
        $return_content .= '<span>';
        $return_content .= FS_PRODUCTS_QA_A;
        //if ($answers_key == 0) {
        //    $return_content .= FS_PRODUCTS_QA_A;
        //}
        $return_content .= '</span>';

        $return_content .= '<p>';
        $return_content .= $answers_val['content_sorted'];
        $return_content .= '<strong class="pro_hiden01">';
        if($_SESSION['languages_code'] !='jp') {
            $return_content .= $answers_val['created_person_sorted'].$answers_val['created_at_sorted'];
        }else{
            $return_content .= $answers_val['created_at_sorted'] .$answers_val['created_person_sorted'] .POPUP_QA_CREATED_BY_JP;
        }
        $disable = !isset($_SESSION['customer_id']) ? 'disabled' : '';
        $praise = $answers_val['praise'] ? $answers_val['praise'] : 0;
        $num = get_one_answer_comments_count($answers_val['id']);
        $tip = !isset($_SESSION['customer_id']) ? FS_QA_SIGN_IN_COMMENT_TIP : FS_PLEASE_W_REVIEW;
        $style = 'class="qa_commentOn_discuss after" onclick="show_more_answers($(this))"';
        if(!isset($_SESSION['customer_id']) && !isMobile()){
            $style = 'class="qa-detail-discuss after toSign-tips-hoverBox" onclick="{JUMP}"';
            $style = str_replace('{JUMP}',"window.location.href = '".zen_href_link(FILENAME_LOGIN, '', 'SSL')."'",$style);
        }
        $files_html = $answers_val['files_id'] != '' ? get_files_html($answers_val['files_id']) : '';
        $return_content .= '</strong>';
        $return_content .= '</p>';
        $return_content .= '</div>';
        $return_content .= $files_html;

        $return_content .= '<div class="qa_commentOn_box">';

        $return_content .= '<div class="qa_commentOn_main">
                                <em class="qa_commentOn_fabulous after" onclick="zan('.$answers_val['id'].', 1);">
                                    <i class="iconfont icon zan'.$answers_val['id'].'">&#xf054;</i><i id="praise_number_'.$answers_val['id'].'_1">'.$praise.'</i>
                                </em>
                                <em '.$style.'>
                                    <i class="iconfont icon">&#xf006;</i>'.$num.'
                                </em>
                            </div>';

        $return_content .= '<div class="qa_commentOn_form">';
        $return_content .= '<div class="qa_commentOn_form_main">';

        $return_content .= '<input type="hidden" name="comment_window_answer_id" value="'.$answers_val['id'].'">
                            <input class="big_input" type="text" name="comment_content" placeholder="'.$tip.'" '.$disable.'>
                            <p class="error_prompt" style="display:none;">
                                <label class="error" for="qa_comment_content">'.FS_QA_COMMENT_TIP.'</label>
                            </p>';

        $return_content .= '<div class="qa_commentOn_btnBox">';
        if(!isset($_SESSION['customer_id'])){
            $_SESSION['navigation']->set_snapshot();
            $jump = "window.location.href = '".zen_href_link(FILENAME_LOGIN, '', 'SSL')."'";
            $return_content .= '<button class="qa_commentOn_btn fs-comSub-loadBtn fs-comSub-loadPink" onclick="'.$jump.'">';
            $return_content .= '<div class="fs-comSub-loadBtn_txt after">'.FS_QA_SIGN_IN_COMMENT.'</div>';
        }else{
            $return_content .= '<button class="qa_commentOn_btn fs-comSub-loadBtn fs-comSub-loadPink" onclick="ajax_answer_review($(this))">';
            $return_content .= '<div class="fs-comSub-loadBtn_txt after">'.FS_COMMON_SUBMIT.'</div>';
        }
        $return_content .= '<div class="loader_order">
                                <svg class="circular" viewBox="25 25 50 50">
                                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>
                                </svg>
                            </div>';
        $return_content .= '</button>';
        $return_content .= '</div>';

        $comments = get_one_answer_comments($answers_val['id']);
        if(sizeof($comments)){
            if($num > 1){
                $num_str = str_replace('{NUM}',$num,FS_QA_SHOWING_COMMENTS_02);
            }else{
                $num_str = str_replace('{NUM}',$num,FS_QA_SHOWING_COMMENTS_01);
            }
            $return_content .= '<div class="qa_commentOn_slideResult_txtBox">';
            $return_content .= '<p class="qa_commentOn_slideResult_tit">'.$num_str.'</p>';
            $return_content .= '<div class="qa_commentOn_slideResult_dev">';
            foreach ($comments as $comment){
                $question_by = '';
                if($_SESSION['languages_code'] !='jp') {
                    if ($comment['created_person_sorted']) {
                        $question_by = POPUP_QA_NEW_BY . ' ' . $comment['created_person_sorted'];
                    }
                    $question_by .= $comment['created_at_sorted'];
                }else{
                    $question_by = $comment['created_at_sorted'].FS_PRODUCTS_QA_ON;
                    if ($comment['created_person_sorted']) {
                        $question_by .=  $comment['created_person_sorted'].POPUP_QA_NEW_BY . ' ' ;
                    }
                }
                $return_content .= '<p>'.$comment['content'].'<strong class="pro_hiden01">'.$question_by.'</strong></p>';
            }
            $return_content .= '</div>';
            $return_content .= '</div>';
        }
        $return_content .='</div>';
        $return_content .='</div>';
        $return_content .='</div>';

        if ($all_answers_count == 1) {
            $return_content .= '<p class="question_answering"><a href="' . $data_href . '">' . FS_QA_ANSWER_TITLE . '<em class="iconfont icon"></em></a></p>';
        }

        $return_content .='</div>';
        $return_content .='</dd>';

        if ($answers_count > 1) {
            $return_content .= '<p class="question_answering"><a href="' . $data_href . '">' . FS_QA_ANSWER_TITLE . '<em class="iconfont icon"></em></a></p>';
            $return_content .= '<p class="qa_see_more">' . POPUP_ANSWER_42 . '<i class="iconfont icon"></i></p>';
        }
    }


    if ($all_answers_count > FS_PRODUCTS_QA_A1_FIRST_NUM ) {
        $return_content .= '<div class="qa_commentOn_moreBox" id="comments_'.$question_id.'">';
        $return_content .= '<a href="javascript:;" onclick="show_qa_all_answers(this,'.$question_id.',\''.$type.'\')">';
        if ($all_answers_count == '2') {
            $return_content .= POPUP_QA_NEW_MORE_ANSWER;
        } else {
            $return_content .= POPUP_QA_NEW_MORE_ANSWERS;
        }
        $return_content .= ' ('.($all_answers_count-1).')';
        $return_content .= '</a>';
        $return_content .= '</div>';
    }

    return $return_content;

}
// 产品详情页面 end------------


// QA详情页面 start-----------------
// QA详情页面 获取一个问题的回答（默认和异步通用）
function QA_get_one_question_answers($question_id,$page='1'){
    $answers = get_one_question_answers($question_id,$page);
    foreach ($answers as $answers_key =>$answers_val  ){
        $comments = get_one_answer_comments($answers_val['id']);
        foreach ($comments as $comments_key => $comments_val){
            $comments[$comments_key]['comment_comments'] = get_one_answer_comment_comment($comments_val['id']);
        }
        $answers[$answers_key]['comments'] = $comments;
        $answers[$answers_key]['comments_count'] = get_one_answer_comments_count($answers_val['id']);
    }

    return $answers;
}

// QA详情页面 展示回答列表html（默认和异步通用）
function QA_answers_show($answers){
    $return_content = '';
    foreach($answers as $answers_key => $answers_val){
        $return_content .=
        '<dl class="qa_dl_contai_dl">
            <dt class="qa_dl_contai_dl_dt">
                <span id="answer_content_'.$answers_val['id'].'" class="qa_dl_contai_dl_dt_content">'.$answers_val['content_sorted'].'</span>';
                if($answers_val['created_person_sorted']){
                    $return_content .=  ' <em>'.POPUP_QA_NEW_BY.' '.$answers_val['created_person_sorted'].'</em>';
                }
                $return_content .= '<span> '.' '.$answers_val['created_at_sorted'].'</span>
            </dt>
            <dd>';

                // 操作
                $return_content .=
                '<div class="qa_dd_toolbar">
                    <ul class="qa_dd_ul">';
                        if($answers_val['comments']){
                            $return_content .= '<li><a class="qa_comments show" href="javascript:;">'.POPUP_QA_NEW_COMMENTS.'</a></li>';
                        }
                        $return_content .=
                        '<li><a href="javascript:;" onclick="show_comment_widow(\''.$answers_val['id'].'\')">'.FS_PRODUCTS_QA_LEAVE_COMMENT.'</a></li>
                        <li>
                            <a href="javascript:;" class="zan'.$answers_val['id'].'" onclick="zan('.$answers_val['id'].', 1);">
                                <i class="icon_img"></i>
                                <span class="praise_number" id="praise_number_'.$answers_val['id'].'_1">';

                                if($answers_val['praise']){
                                    $return_content .=  $answers_val['praise'];
                                }
                                $return_content .=  '</span> ';
                                if($answers_val['praise']==0 || $answers_val['praise']==1){
                                    $return_content .=  POPUP_QA_NEW_HELP_VOTE;
                                }else{
                                    $return_content .=  POPUP_QA_NEW_HELP_VOTES;
                                }
                            $return_content .=
                            '</a>
                        </li>
                        <li>
                            <a href="javascript:;" class="zan'.$answers_val['id'].'"';
                                if($answers_val['step_sorted'] == POPUP_QA_NEW_REPORT){  $return_content .= 'onclick="zan('.$answers_val['id'].',0)"'; }
                                $return_content .= '>
                                <span class="qa_span03" href="javascript:;" id="praise_number_'.$answers_val['id'].'_0" >'.$answers_val['step_sorted'].'</span>
                            </a>
                        </li>
                    </ul>
                </div>';
    
                //评论
                if ($answers_val['comments']) {
                    $comments_count = $answers_val['comments_count'];
                    $return_content .=
                    '<div class="qa_hide01">
                        <dl class="qa_hide_dl">
                            <dt>
                            <h2 class="qa_hide01_tit">';
                                $default_comment_count = $comments_count<2?$comments_count:2;
                                if($default_comment_count==1){$show_comment_count=POPUP_QA_NEW_MORE_COMMENT;}else{$show_comment_count=POPUP_QA_NEW_MORE_COMMENTS;}
                                $show_comment_count = str_replace('{COMMENT_COUNT}',$default_comment_count,$show_comment_count);
                                $return_content .= $show_comment_count;

                            $return_content .=
                            '</h2>
                            </dt>
                            <dd>';
                                $first_comment_comments = '';
                                foreach($answers_val['comments'] as $comments_key => $comments_val){
                                    if($comments_key == 0 ){
                                        $first_comment_comments = $comments_val['comment_comments'];
                                        $return_content .= '<p>';
                                    }elseif ($comments_key == 1 ){
                                        if( $first_comment_comments ){ //如果存在对评论的回复，则从第2条隐藏
                                            $return_content .= '<p style = "display: none;" >';
                                        }else{ //如果不存在对评论的回复，则从第3条隐藏
                                            $return_content .= '<p>';
                                        }
                                    }elseif ($comments_key > 1 ){
                                        $return_content .= '<p style = "display: none;" >';
                                    }
                                        $return_content .= $comments_val['content_sorted'];
                                        if($comments_val['created_person_sorted']){
                                            $return_content .= ' <em>'.POPUP_QA_NEW_BY.' '.$comments_val['created_person_sorted'].'</em>';
                                        }
                                        $return_content .= '<span>' .' '. $comments_val['created_at_sorted'].'</span>';
                                    $return_content .= '</p>';

                                    // 对用户评论的回复
                                    if($comments_val['comment_comments']){
                                        if($comments_key==0){
                                            $return_content .= '<p>';
                                        }elseif ($comments_key > 0 ){
                                            $return_content .= '<p style = "display: none;" >';
                                        }
                                        $return_content .= $comments_val['comment_comments']['content_sorted'];
                                        if($comments_val['comment_comments']['created_person_sorted']){
                                            $return_content .= '<em>'.POPUP_QA_NEW_BY.' '.$comments_val['comment_comments']['created_person_sorted'].'</em>';
                                        }
                                        $return_content .= '<span>' . $comments_val['comment_comments']['created_at_sorted'].'</span>';
                                        $return_content .= '</p>';
                                    }
                                }

                                if ($comments_count>2) {
                                    $return_content .=
                                    '<div class="qa_more01">
                                        <a class="qa_more02 show_qa_all_comments" href="javascript:;" data-default-count="'.$default_comment_count.'" data-all-count="'.$comments_count.'">';
                                        if($comments_count=='2'){
                                            $return_content .= FS_PRODUCTS_QA_MORE_COMMENT;
                                        }else{
                                            $return_content .= FS_PRODUCTS_QA_MORE_COMMENTS;
                                        }
                                        $return_content .= ' ('.($comments_count-2).')</a>';
                                        $return_content .=
                                        '<i class="iconfont icon">&#xf087;</i>
                                    </div>';
                                }
                            $return_content .=
                            '</dd>
                        </dl>
                    </div>';
                }

            $return_content .=
            '</dd>
        </dl>';
    }
    return $return_content;
}
// QA详情页面 end-----------------


// 公共的方法 start-----------------
// QA时间的展示形式
function qa_time_show($created_at,$is_timestamp=false){
    if(!$is_timestamp){
        $created_at = strtotime($created_at);
    }
    if($_SESSION['languages_id']==1){
        $created_at_sorted = '<em> '.FS_PRODUCTS_QA_ON.'</em> '.' '.date('m/d/Y', $created_at);
    }elseif($_SESSION['languages_id']==5){ //德语不太一样
        $created_at_sorted = '<em> '.FS_PRODUCTS_QA_ON.'</em> '.' '.date('d.m.Y', $created_at);
    }elseif ($_SESSION['languages_id']==2){
        $created_at_sorted = '<em> '.FS_PRODUCTS_QA_ON.'</em> '.' '.get_date_display(date('d.m.Y', $created_at),$_SESSION['languages_id']);
    }elseif($_SESSION['languages_id']==8){
        $created_at_sorted = get_date_display(date('d.m.Y', $created_at),$_SESSION['languages_id']).FS_PRODUCTS_QA_ON;
    }else{
        $created_at_sorted = '<em> '.FS_PRODUCTS_QA_ON.'</em> '.' '.date('d/m/Y', $created_at);
    }
    return $created_at_sorted;
}

/**
 * 回答问题的人名
 * @param $msg
 * @return string
 */
function AQ_name_new($type,$from_admin_or_home,$created_person,$email,$nickname){
    global $db;
    $created_username = '';
    if($from_admin_or_home == 2){
        if($type == 'question' || $type == 'answer'){
            if($nickname){
                $created_username = $nickname;
            }else{
                $admin = $db->Execute("SELECT `admin_name` FROM `admin` WHERE `admin_id`=".$created_person);
                $created_username = $admin->fields['admin_name'];
            }
            $created_username = hide_name($created_username);
        }else{
            $created_username = 'FS';
        }
    }else{
        if($nickname){
            $created_username = $nickname;
        }else{
            if($created_person){
                $name_sql = "SELECT customers_firstname,customers_lastname FROM `customers` WHERE customers_id ='".$created_person."'";
            }elseif($email){
                $name_sql = "SELECT customers_firstname,customers_lastname FROM `customers` WHERE `customers_email_address`='{$email}' OR `customers_email` = '{$email}'";
            }
            if($name_sql){
                $name_ret = $db->Execute($name_sql);
                if($name_ret->fields['customers_firstname'] || $name_ret->fields['customers_lastname']){
                    $created_username = $name_ret->fields['customers_firstname'].'.'.$name_ret->fields['customers_lastname'];
                }
            }
        }
        $created_username = hide_name($created_username);
    }
    if(!empty($created_username) && $_SESSION['languages_code'] =='jp'){
        $created_username .= POPUP_QA_NEW_BY;
    }else{
        $created_username = POPUP_QA_NEW_BY  .' ' .$created_username .' ';
    }
    return $created_username;
}

// 是否点过赞
function is_give_not_like($answer_id){
    global $db;
    $ip = $_SERVER['REMOTE_ADDR'];
    $today_start = date('Y-m-d H:i:s',strtotime(date('Y-m-d')) );
    $today_end = date('Y-m-d H:i:s',strtotime(date('Y-m-d 23:59:59')) );
    $ip_query = "select id,ip from question_answer_guest_ip 
    where answer_id=".$answer_id." and ip='".$ip."' and type=0 and created_at>='".$today_start."' and created_at<='".$today_end."' and language_id=".(int)$_SESSION['languages_id'];
    $comments_result = $db->getAll($ip_query);
    if($comments_result[0]['id']){
        return true;
    }else{
        return false;
    }
}
// 公共的方法 end-----------------

// QA详情页面 展示回答列表html（默认和异步通用）
function new_QA_answers_show($answers){
    $return_content = '';
    foreach($answers as $answers_key => $answers_val){
        $return_content .= '<li class="qa-detail-listLi">
                            <div class="qa-detail-questionTit" id="answer_content_'.$answers_val['id'].'">
                            '.$answers_val['content_sorted'];
        $return_content .= '<span>';
        if($_SESSION['languages_code'] =='jp'){
            $return_content .=$answers_val['created_at_sorted'] . $answers_val['created_person_sorted'] .POPUP_QA_CREATED_BY_JP;
        }else {
            $return_content.= $answers_val['created_person_sorted'].$answers_val['created_at_sorted'];
        }
        $return_content .= '</span></div>';
        if($answers_val['files_id'] != ''){
            $return_content .= get_files_html($answers_val['files_id']);
        }
        $num_str = '';
        if($answers_val['comments_count'] > 0){
            if($answers_val['comments_count'] == 1){
                $num_str = str_replace('{NUM}',$answers_val['comments_count'],FS_QA_SHOWING_COMMENTS_01);
            }else{
                $num_str = str_replace('{NUM}',$answers_val['comments_count'],FS_QA_SHOWING_COMMENTS_02);
            }
        }
        $praise = $answers_val['praise'] ? $answers_val['praise'] : 0;
        $style = 'class="qa-detail-discuss" onclick="show_comment_list($(this))"';
        if(!isset($_SESSION['customer_id']) && !isMobile()){
            $style = 'class="qa-detail-discuss toSign-tips-hoverBox" onclick="{JUMP}"';
            $style = str_replace('{JUMP}',"window.location.href = '".zen_href_link(FILENAME_LOGIN, '', 'SSL')."'",$style);
        }
        $return_content .= '<div class="qa-detail-commentOnBox after">
			        				<em class="zan'.$answers_val['id'].'" onclick="zan('.$answers_val['id'].', 1);"><i class="iconfont icon">&#xf054;</i><i id="praise_number_'.$answers_val['id'].'_1">'.$praise.'</i></em>
			        				<em '.$style.'><i class="iconfont icon">&#xf006;</i>'.$answers_val['comments_count'].'</em>
			        			</div>';

        $disable = '';
        $onclick = 'ajax_answer_review($(this))';
        $btn = FS_COMMON_SUBMIT;
        $tip = FS_PLEASE_W_REVIEW;
        if (!isset($_SESSION['customer_id'])) {
            $_SESSION['navigation']->set_snapshot();
            $onclick = "window.location.href = '".zen_href_link(FILENAME_LOGIN, '', 'SSL')."'";
            $disable = 'disabled';
            $btn = FS_QA_SIGN_IN_COMMENT;
            $tip = FS_QA_SIGN_IN_COMMENT_TIP;
        }
        $return_content .= '<div class="qa_commentOn_form">
                                <div class="qa_commentOn_form_main">
                                    <input type="hidden" name="comment_window_answer_id" value="'.$answers_val['id'].'">
                                    <input class="big_input" type="text" name="comment_content" placeholder="'.$tip.'" '.$disable.'>
                                    <p class="error_prompt" style="display: none;">
                                        <label class="error" for="qa_comment_content">'.FS_QA_COMMENT_TIP.'</label>
                                    </p>
                                    <div class="qa_commentOn_btnBox">
                                        <button class="qa_commentOn_btn fs-comSub-loadBtn fs-comSub-loadPink" onclick="'.$onclick.'">
                                            <div class="fs-comSub-loadBtn_txt after">'.$btn.'</div>
                                            <div class="loader_order">
                                                <svg class="circular" viewBox="25 25 50 50">
                                                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10">
                                                    </circle>
                                                </svg>
                                            </div>
                                        </button>
                                    </div>';
        if(sizeof($answers_val['comments'])){
            $return_content .= '<div class="qa-detail-child-questionBox">
                                <div class="qa-detail-child-questionTit">'.$num_str.'</div>';
            foreach ($answers_val['comments'] as $comment){
                /*
                $return_content .= '<div class="qa-detail-child-txt">
                                    <span>'.POPUP_QA_NEW_BY.' '.$comments['created_person_sorted'].$answers_val['created_at_sorted'].'</span>
                                </div>';
                */
                $question_by = '';
                if($_SESSION['languages_code'] !='jp') {
                    if ($comment['created_person_sorted']) {
                        $question_by = POPUP_QA_NEW_BY . ' ' . $comment['created_person_sorted'];
                    }
                    $question_by .= $comment['created_at_sorted'];
                }else{
                    $question_by = $comment['created_at_sorted'].FS_PRODUCTS_QA_ON;
                    if ($comment['created_person_sorted']) {
                        $question_by .=  $comment['created_person_sorted'].POPUP_QA_NEW_BY . ' ' ;
                    }
                }
                $return_content .= '<div class="qa-detail-child-txt">'.$comment['content'].'<span>'.POPUP_QA_NEW_BY.' '.$comment['created_person_sorted'].$answers_val['created_at_sorted'].'</span></div>';
            }
            $return_content .= '</div>';
        }


        $return_content .= '</div></div></li>';
    }
    return content_preg_mtp($return_content);
}

function hide_name($name){
    if($name == 'FS'){
        return $name;
    }else{
        $first_str = mb_substr($name,0,1,'utf-8');
        $last_str = mb_substr($name,-1,1,'utf-8');
        return $first_str."***".$last_str;
    }
}

function get_files_html($files_id){
    $html = '';
    if($files_id != ''){
        global $db;
        $filesArr = $db->getAll('select qa_file_name,storage_path,storage_name from question_answer_files where id in ('.$files_id.')');
        $file_html = $img_html = '';
        $i=1;
        foreach ($filesArr as $k=>$file_v){
            $qa_file_name = $file_v['qa_file_name'];
            $file_path = HTTPS_IMAGE_SERVER.DIR_WS_IMAGES.'reviews/'.$file_v['storage_path'].'/'.$file_v['storage_name'];
            if(strpos($qa_file_name,'jpg') || strpos($qa_file_name,'png')){
                /*$img_info = getimagesize($file_path);
                $width = $img_info[0];
                $height = $img_info[1];
                if($width > $height){
                    $height = $height/($width/100);
                    $width = 100;
                }elseif($width < $height){
                    $width = $width/($height/100);
                    $height = 100;
                }else{
                    $width = $height = 100;
                }*/
                $img_html .= '<div class="qa_result_imagesMain_box">
                        <img value="'.$i.'" src="'.$file_path.'" height="100" title="'.$qa_file_name.'">
                    </div>';
                $i++;
            }else{
                $file_html .= '<a href="'.$file_path.'" target="_blank">
                        <i class="iconfont qa_result_filesIc">&#xf300;</i><em class="qa_result_filesTxt">'.$qa_file_name.'</em>
                    </a>';
            }
        }
        $html = '<div class="qa_result_filesBox">';
        if($file_html != ''){
            $html .= '<div class="qa_result_filesMain01">'.$file_html.'</div>';
        }
        if($img_html != ''){
            $html .= '<div class="qa_result_imagesMain m_pic">'.$img_html.'</div>';
        }
        $html .= '</div>';
    }
    return $html;
}

/**
 * 技术人员分配
 * @param $distType             1、售前技术支持分配   2、售前方案研发分配   3、售后技术支持分配  4、liveChat技术分配 5、QA技术分配
 * @param bool $distStatus      false：查询对应的技术人员   true：查询对应的技术人员并立即分配
 * @param array $errGroups      异常的小组
 * @return int                  返回技术人员id（如果返回0则代表没有匹配的技术人员）
 */
function technicalSupportAllocation($distType,$distStatus = true,array $errGroups = [0])
{
    global $db;
    $station = 6;       //分配的技术要求为业务岗
    $seniorEngineer = 1;    //高级工程师
    $engineer = 3;      //工程师
    switch ($distType){
        case 1:         //售前技术支持分配（沟通系统线下case提问《技术支持部》）
            $group_type = [1];    //售前组参与问题
            $professor = [$engineer];     //分配工程师职称的技术人员
            $groupStatusField = 'pre_sale_tech_dist_status';
            $techDistField = 'pre_sale_tech_re_num';
            break;
        case 2:         //售前方案研发分配（沟通系统线下case提问《方案研发部》）
            $group_type = [1];    //售前组参与问题
            $professor = [$seniorEngineer];     //分配高级技术工程师职称的技术人员
            $groupStatusField = 'pre_sale_solution_dist_status';
            $techDistField = 'pre_sale_solution_re_num';
            break;
        case 3:         //售后技术支持分配（沟通系统订单问答提问《技术支持部》）
            $group_type = [2];      //售后组参与问题
            $professor = [$seniorEngineer,$engineer];     //分配高级技术工程师和工程师职称的技术人员
            $groupStatusField = 'after_sale_technical_dist_status';
            $techDistField = 'after_sale_technical_re_num';
            break;
        case 4:         //live chat技术支持分配
            $group_type = [1,2];    //售前售后组都参与分配
            $professor = [$seniorEngineer];     //分配高级技术工程师职称的技术人员
            $groupStatusField = 'live_chat_dist_status';
            $techDistField = 'live_chat_re_num';
            break;
        case 5:         //QA技术支持分配
            $group_type = [1];    //售前组参与问题
            $professor = [$engineer];     //分配工程师职称的技术人员
            $groupStatusField = 'qa_dist_status';
            $techDistField = 'qa_re_num';
            break;
        default:
            return 0;
            break;
    }
    $group_type = implode(',',$group_type);
    $professor = implode(',',$professor);
    //查询符合要求的小组
    $groupData = fs_get_data_from_db_fields_array(['id','leader_id','group_name'],'consult_tech_bind','delete_time = 0 AND roles = 1 AND group_type in ('.$group_type.') AND '.$groupStatusField.' = 0 AND id not in ('.implode(',',$errGroups).')','limit 1');
    if(empty($groupData)){  //如果当前不存在未分配的小组，则重置小组的分配数据
        zen_db_perform('consult_tech_bind',[$groupStatusField => 0],'update','delete_time = 0 AND roles = 1 AND group_type in ('.$group_type.')');
        $groupData = fs_get_data_from_db_fields_array(['id','leader_id','group_name'],'consult_tech_bind','delete_time = 0 AND roles = 1 AND group_type in ('.$group_type.') AND '.$groupStatusField.' = 0 AND id not in ('.implode(',',$errGroups).')','limit 1');
    }
    if(empty($groupData)){  //如果重置分配数据后，依然不存在匹配的小组
        return 0;
    }
    $group_id = $groupData[0][0];
    $leader_id = $groupData[0][1];
    $group_name = $groupData[0][2];
    //查询该小组中匹配的技术人员
    $techData = fs_get_data_from_db_fields_array(['id','member_id'],'consult_tech_bind','delete_time = 0 AND roles = 2 AND station = '.$station.' AND professor in ('.$professor.') AND group_name = \''.$group_name.'\' AND leader_id = '.$leader_id.' AND '.$techDistField .' > 0','limit 1');
    if(empty($techData)){   //如果当前不存在未分配的技术人员，则重置当前小组的分配数据
        if($distType == 3){ //如果是售后技术重置分配（工程师分配2次，高级工程师分配1次）
            $db->Execute('UPDATE `consult_tech_bind` SET `'.$techDistField.'` = CASE WHEN `professor` = '.$seniorEngineer.' THEN 1 WHEN `professor` = '.$engineer.' THEN 2 ELSE 0 END 
                WHERE `delete_time` = 0 AND `roles` = 2 AND `professor` in ('.$professor.') AND `group_name` = \''.$group_name.'\' AND `leader_id` = '.$leader_id);
        }else{
            zen_db_perform('consult_tech_bind',[$techDistField => 1],'update','delete_time = 0 AND roles = 2 AND professor in ('.$professor.') AND group_name = \''.$group_name.'\' AND leader_id = '.$leader_id);
        }
        $techData = fs_get_data_from_db_fields_array(['id','member_id'],'consult_tech_bind','delete_time = 0 AND roles = 2 AND station = '.$station.' AND professor in ('.$professor.') AND group_name = \''.$group_name.'\' AND leader_id = '.$leader_id.' AND '.$techDistField .' > 0','limit 1');
    }
    if(empty($techData)){   //如果重置后，依然不存在匹配的技术人员，则跳过此小组重新查询
        $errGroups[] = $group_id;
        return technicalSupportAllocation($distType,$distStatus,$errGroups);
    }
    $tech_id = $techData[0][0];
    $member_id = $techData[0][1];
    //开始技术人员分配
    if($distStatus){
        $db->Execute('UPDATE `consult_tech_bind` SET `'.$groupStatusField.'` = CASE WHEN `id` = '.$group_id.' THEN 1 END,
            `'.$techDistField.'` = CASE WHEN `id` = '.$tech_id.' THEN `'.$techDistField.'` - 1 END 
            WHERE `id` = '.$group_id.' OR `id` = '.$tech_id);
    }
    return $member_id;
}
?>
