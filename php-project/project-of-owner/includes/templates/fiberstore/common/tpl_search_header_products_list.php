<?php if($_GET['Popular_id']){ ?>
    <script type="text/javascript">
        $('.last_no').prev('.my_dashboard').children('a').css('color','#c00000');
        $('.last_no').prev('.my_dashboard').children('a').html('<h1 style="font-size:13px" itemprop="title"><?php echo $keyword;?></h1>');
    </script>
<?php } ?>
<?php
$per_page_list = array(array('id'=>'24','text'=>'24'),array('id'=>'36','text'=>'36'),array('id'=>'48','text'=>'48'));
$countries_code_2 = $_SESSION['countries_code_21'];
switch ($order){
    case "popularity":
        $sort_html = FS_POPULARITY;
        $popselected ='choosez';
        $popsesleed ='selected = "selected"';
        break;
    case "price":
        $sort_html = FS_PRICE_LOW_HIGH;
        $priceselected ='choosez';
        $pricesleed ='selected = "selected"';
        break;
    case "new":
        $sort_html = FS_NEWEST_FIRST;
        $newselected ='choosez';
        $newsleed ='selected = "selected"';
        break;
    case "priced":
        $sort_html = FS_PRICE_HIGH_LOW;
        $pricedselected ='choosez';
        $pricedsleed ='selected = "selected"';
        break;
    case "rate":
        $sort_html = FS_RATE_HOGH;
        $rateselected ='choosez';
        $ratesleed ='selected = "selected"';
        break;
    default:
        $sort_html = FS_POPULARITY;
}
switch($_GET['count']){
    case '36':
        $count_one = 'choosez';
        break;
    case '48':
        $count_two = 'choosez';
        break;
}
?>
<?php
if($style == 'images'){
    $video_array_btn = '';
    $picture_array_btn = 'choosez';
}elseif($style == 'list'){
    $video_array_btn = 'choosez';
    $picture_array_btn = '';
}elseif($style == ""){
    $video_array_btn = '';
    $picture_array_btn = 'choosez';
}

?>
<style>
    @media (max-width:960px){
        .p_hot_01,.v_show{padding:0 10px;}
    }
</style>
<div class="tit_select_bigBox">
    <div class="classify_big_tit">
        <h1><span><?php echo "“".$final_keyword."“"?></span> <?php ECHO FIBERSTORE_SEARCH_FOUND;?>
            <span><?php echo $search_products_total_num;?></span>
            <?php
            $number = $search_products_total_num;
            if($number > 1){
                echo FIBERSTORE_SEARCH_ITEMS;
            }else{
                echo FIBERSTORE_SEARCH_ITEM;
            }
            ?>
        </h1>
        <?php
        $html ="";
        if(is_array($relate_key_arr)&&!empty($relate_key_arr)){
            $html.='<div class="p_hot_search"><b style="font-size:13px;">'.RELATED_HOT_SEARCH_PRODUCTS.': </b>';
            foreach ($relate_key_arr as $v){
                $keyword_url= $v['tag_url'];
                if($keyword_url){
                    $html .='<a  href="'.$keyword_url.'">'.$v['keywords'].'</a>';
                }else{
                    $html .='<a  href="'.zen_href_link('Popular_detail','&Popular_id='.$v['id']).'">'.$v['keywords'].'</a>';
                }
            }
            $html.='</div>';
        }else{
            $html .= '<div></div>';
        }
        echo $html;
        ?>
    </div>
    <div class="mation_select_box">
        <div class="mation_select_left">
            <?php
            if($search_products_total_num == 0){
                $page_start_num = 0;
            }else{
                $page_start_num = ($fs_result->number_of_rows_per_page * ($fs_result->current_page_number-1)+1);
            }
            if($search_products_next_page != $search_products_total_page){
                $page_current_num = $fs_result->number_of_rows_per_page * $fs_result->current_page_number;
            }else{
                $page_current_num = $search_products_total_num;
            }
            ?>
            <span class="mation_page_guide"><?php echo FIBERSTORE_SHOWING;?> <?php echo $page_start_num;?>-<?php echo $page_current_num;?> <?php echo FIBERSTORE_OF;?> <?php echo $search_products_total_num;?>
                <?php
                if($search_products_total_num>1){
                    echo FIBERSTORE_PRODUCTS;
                }else{
                    echo FIBERSTORE_PRODUCT;
                }
                ?>
            </span>
        </div>
        <div class="mation_select_right">
            <span class="popularity_view_box select_two <?php echo $video_array_btn;?>">
                 <span class="popularity_view_list ">
                    <span class="popularity_view_block01 ">
                        <?php echo FIBERSTORE_RESULTS_BY01;?>  <p class="popularity_view_sort"><span class="numT"><?php echo $sort_html;?></span><span class="iconfont popularity_view_sortic">&#xf087;</span></p>
                        <?php echo FIBERSTORE_RESULTS_VIEW;?>  <p class="popularity_view_num" ><span class="numT"><?php echo isset($_GET['count']) ? $_GET['count']:24;?></span><span class="iconfont popularity_view_sortic">&#xf087;</span></p>
                    </span>
                    <div class="popularity_view_list1">
                        <div class="popularity_view_list1_arrow"></div>
                        <ol>
                            <li data="price" class="<?php echo $priceselected;?>" onclick="change_sort_order_by($(this).attr('data'),'images','',$(this))"><?php echo FS_PRICE_LOW_HIGH;?></li>
                            <li data="priced" class="<?php echo $pricedselected;?>" onclick="change_sort_order_by($(this).attr('data'),'images','',$(this))"><?php echo FS_PRICE_HIGH_LOW;?></li>
                            <li data="rate" class="<?php echo $rateselected;?>" onclick="change_sort_order_by($(this).attr('data'),'images','',$(this))"><?php echo FS_RATE_HOGH;?></li>
                            <li data="new" class="<?php echo $newselected;?>" onclick="change_sort_order_by($(this).attr('data'),'images','',$(this))"><?php echo FS_NEWEST_FIRST;?></li>
                            <li data="popularity" class="<?php if(isset($_GET["sort_order"]) && $_GET["sort_order"]!= "popularity"){ echo '';}else{echo 'choosez';}?>" onclick="change_sort_order_by($(this).attr('data'),'images','',$(this))"><?php echo FS_POPULARITY;?></li>
                        </ol>
                    </div>
                    <div class="popularity_view_list2">
                        <div class="popularity_view_list2_arrow"></div>
                        <ol>
                            <li class="<?php if(isset($_GET['count']) && $_GET['count'] != '24'){ echo '';}else{ echo 'choosez';}?>" onclick="change_sort_order_by('','images',$(this).attr('data'),$(this))" data="24">24</li>
                            <li class="<?php echo $count_one;?>" onclick="change_sort_order_by('','images',$(this).attr('data'),$(this))" data="36">36</li>
                            <li class="<?php echo $count_two;?>" onclick="change_sort_order_by('','images',$(this).attr('data'),$(this))" data="48">48</li>
                        </ol>
                    </div>
                </span>
            </span>
            <span class="popularity_view_box select_one <?php echo $picture_array_btn;?>">
                <span class="popularity_view_list  choosez">
                    <span class="popularity_view_block01 ">
                        <?php echo FIBERSTORE_RESULTS_BY01;?>  <p class="popularity_view_sort"><span class="numT"><?php echo $sort_html;?></span><span class="iconfont popularity_view_sortic">&#xf087;</span></p>
                        <?php echo FIBERSTORE_RESULTS_VIEW;?>  <p class="popularity_view_num" ><span class="numT"><?php echo isset($_GET['count']) ? $_GET['count']:24;?></span><span class="iconfont popularity_view_sortic">&#xf087;</span></p>
                    </span>
                    <div class="popularity_view_list1">
                        <div class="popularity_view_list1_arrow"></div>
                        <ol>
                            <li data="price" class="<?php echo $priceselected;?>" onclick="change_sort_order_by($(this).attr('data'),'list','',$(this))"><?php echo FS_PRICE_LOW_HIGH;?></li>
                            <li data="priced" class="<?php echo $pricedselected;?>" onclick="change_sort_order_by($(this).attr('data'),'list','',$(this))"><?php echo FS_PRICE_HIGH_LOW;?></li>
                            <li data="rate" class="<?php echo $rateselected;?>" onclick="change_sort_order_by($(this).attr('data'),'list','',$(this))"><?php echo FS_RATE_HOGH;?></li>
                            <li data="new" class="<?php echo $newselected;?>" onclick="change_sort_order_by($(this).attr('data'),'list','',$(this))"><?php echo FS_NEWEST_FIRST;?></li>
                            <li data="popularity" class="<?php if(isset($_GET["sort_order"]) && $_GET["sort_order"]!= "popularity"){ echo '';}else{echo 'choosez';}?>" onclick="change_sort_order_by($(this).attr('data'),'list','',$(this))"><?php echo FS_POPULARITY;?></li>
                        </ol>
                    </div>
                    <div class="popularity_view_list2">
                        <div class="popularity_view_list2_arrow"></div>
                        <ol>
                            <li class="<?php if(isset($_GET['count']) && $_GET['count'] != '24'){ echo '';}else{ echo 'choosez';}?>" onclick="change_sort_order_by('','list',$(this).attr('data'),$(this))" data="24">24</li>
                            <li class="<?php echo $count_one;?>" onclick="change_sort_order_by('','list',$(this).attr('data'),$(this))" data="36">36</li>
                            <li class="<?php echo $count_two;?>" onclick="change_sort_order_by('','list',$(this).attr('data'),$(this))" data="48">48</li>
                        </ol>
                    </div>
                </span>
            </span>

            <ul class="Menu_box">
                <li class="picture_array_btn <?php  echo  $picture_array_btn;?>" id="one2">
                    <i class="picture_array_ic"></i>
                </li>
                <li class="video_array_btn <?php  echo  $video_array_btn;?>" id="one1">
                    <i class="video_array_ic"></i>
                </li>
                <li class="sellist_array_btn choosez" id="one4">
                    <i class="sellist_array_ic"></i>
                </li>
            </ul>
        </div>
    </div>
</div>