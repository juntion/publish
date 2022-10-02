<?php
/*
 * 个人中心导航
 * 2018.11.29 fairy 个人中心改版　
 */

$url_name="";
//获取M端页面名称
switch ($_GET['main_page']){
    case 'my_dashboard':
     $url_name =FS_MY_ACCOUNT;
     break;
    case 'edit_my_account':
        $url_name =ACCOUNT_SETTING;
        break;
    case 'manage_orders':
        $url_name =MANAGE_ORDER_HISTORY;
        break;
    case 'manage_addresses':
        $url_name =FS_ADDRESS_BOOK;
        break;
    case 'my_cases':
        $url_name =FS_MY_CASES;
        break;
    case 'inquiry_list':
        $url_name =FS_MY_QUOTES;
        break;
    case 'account_history_info':
        $url_name =MANAGE_ORDER_DETAILS;
        break;
    case 'sales_service_list':
        $url_name =MANAGE_ORDER_HISTORY;
        break;
    case 'sales_service_details':
        $url_name =FS_SALES_DETAILS_SERVICE_TYPE2;
        break;
    case 'inquiry_detail':
        $url_name =FS_INQUIRY_QUOTE_DETAIL;
        break;
    case 'my_cases_details':
        $url_name =FS_CASE_CONTENT;
        break;
    case 'sales_service_info':
        $url_name =FS_SALES_INFO_REQUEST_TYPE2;
        break;
    case 'orders_review':
        $url_name =FS_ORDER_REVIEW;
        break;
    case 'return_guidelines':
        $url_name =FS_EASY_RETURN;
        break;
    case 'coding_requests':
        if($_GET['action'] == 'details'){
            $url_name = CODING_REQUESTS_CODING_DETAILS;
        }else{
            $url_name = CODING_REQUESTS_LIST;
        }
        break;
    default;
} ?>

<div class="new_dashboard_top">
    <dl class="new_dashboard_top_dl">
        <dt><?php if ($url_name == ''){echo FS_CREDIT;}else{echo $url_name;} ?> <i class="iconfont icon"></i></dt>
        <dd class="my_dashboard">
            <a href="<?php echo zen_href_link('my_dashboard','','SSL');?>"><?php echo FS_MY_ACCOUNT;?></a>
        </dd>
        <dd class="edit_my_account">
            <a href="<?php echo zen_href_link('edit_my_account','','SSL');?>"><?php echo ACCOUNT_SETTING;?></a>
        </dd>
        <dd class="manage_orders">
            <a href="<?php echo zen_href_link('manage_orders','','SSL');?>"><?php echo MANAGE_ORDER_HISTORY;?></a>
        </dd>
        <dd class="manage_addresses">
            <a href="<?php echo zen_href_link('manage_addresses','','SSL');?>">
                <?php echo FS_ADDRESS_BOOK;?>
            </a>
        </dd>
        <dd class="my_cases">
            <a href="<?php echo zen_href_link(FILENAME_MY_CASES,'','SSL');?>">
                <?php echo FS_MY_CASES;?>
                <?php $myCaseNumber = getReplayNumbers();
                if($myCaseNumber){ ?>
                    <i class="new_i_num"><?php echo $myCaseNumber;?></i>
                <?php } ?>
            </a>
        </dd>
        <dd class="inquiry_list">
            <a href="<?php echo zen_href_link('inquiry_list','','SSL');?>">
                <?php echo FS_MY_QUOTES;?>
            </a>
        </dd>
        <?php
        //获取改码申请记录
        $res_obj = get_coding_request('list');
        $res_obj = $res_obj['data'];
        $total = $res_obj->total;//总条数
        if($total > 0){
            ?>
            <dd class="coding_requests">
                <a href="<?php echo zen_href_link('coding_requests','','SSL');?>">
                    <?php echo FS_ACCOUNT_MY_CODING_REQUESTS;?>
                </a>
            </dd>
        <?php }?>
    </dl>
</div>
<script type="text/javascript">
    $('.new_dashboard_top_dl dt').click(function(){
        if($('.new_dashboard_top_dl').hasClass('active')){
            $('.new_dashboard_top_dl dd').slideUp();
            $('.new_dashboard_top_dl').removeClass('active');
        }else{
            $('.new_dashboard_top_dl dd').slideDown();
            $('.new_dashboard_top_dl').addClass('active');
        }
    })
    function showActive(){
        $('.new_dashboard_top_dl dd[class=<?php echo $_GET['main_page'];?>]').addClass('active');
    }
    showActive();
</script>