<script type="text/javascript">
    $(function(){
        $(".select > dt > a").click(function(){
            if('sidebar_06_js' == this.className) {
                $(this).removeClass('sidebar_06_js').addClass('sidebarForJS');
            }else{
                $(this).removeClass('sidebarForJS').addClass('sidebar_06_js');
            }
            $(this).parent().siblings().slideToggle('fast');
        });
    });

    function narrow_by_pop(url){
        open(url);
    }
</script>
<?php

    $div_class_str = 'new_proList_mainProse';

?>
<?php if(!$is_mobile){ ?>
    <div class="<?php echo $div_class_str;?>">
<?php } ?>
    <?php
    $narrow_para = '';
    $narrow_link = array('keyword','sort','style','count','Popular_id','sort_order');
    foreach($_GET as $getname=>$getvalue){
        if(in_array($getname,$narrow_link)){
            if($getname == 'keyword'){
                $narrow_para .= '&'.$getname.'='.$keyword;
            }else{
                $narrow_para .= '&'.$getname.'='.$getvalue;
            }
        }
    }
    if(!$is_mobile){
        echo $products_narrow_by->fs_search_products_narrow_by_list_new_pc($all_search_product,$get_narrow,$keyword,$words,$key_array,'old',FILENAME_ADVANCED_SEARCH_RESULT, $narrow_para);
    }else{
        echo $products_narrow_by->fs_search_products_narrow_by_list_new($all_search_product,$get_narrow,$keyword,$words,$key_array,'old',FILENAME_ADVANCED_SEARCH_RESULT, $narrow_para);
    }
    ?>
    <?php
    if(sizeof($get_narrow) && !$is_mobile){
        ?>
        <div class="new_proList_reciveCont_Products">
            <a href="<?php echo zen_href_link(FILENAME_ADVANCED_SEARCH_RESULT,'&keyword='.$keyword);?>" onclick="spinloader()">
                <p class="new_proList_reciveTxt"><?php echo FS_CLEAR_SELECTIONS;?></p>
                <span class="iconfont icon">&#xf092;</span>
            </a>
        </div>
        <?php
    }
    ?>
<?php if(!$is_mobile){ ?>
        <dl class="popularity_view_listz1 <?php echo $video_array_btn;?>">
            <dt class="popularity_view_sortz1">
                <p><span class="popularity_view_sortTxt"><?php echo FIBERSTORE_RESULTS_BY01;?></span><span class="popularity_view_sortPriceTxt"><?php echo $sort_html;?></span><span class="iconfont icon">&#xf087;</span></p>
            </dt>
            <dd class="popularity_view_listz1_li">
                <div class="popularity_view_listz1_liMain <?php echo $priceselected;?>" data="price" onclick="change_sort_order_by_new($(this).attr('data'),'images','',$(this))">
                    <p><?php echo FS_PRICE_LOW_HIGH;?></p>
                </div>
                <div class="popularity_view_listz1_liMain <?php echo $pricedselected;?>" data="priced" onclick="change_sort_order_by_new($(this).attr('data'),'images','',$(this))">
                    <p><?php echo FS_PRICE_HIGH_LOW;?></p>
                </div>
                <div class="popularity_view_listz1_liMain <?php echo $rateselected;?>" data="rate" onclick="change_sort_order_by_new($(this).attr('data'),'images','',$(this))">
                    <p><?php echo FS_RATE_HOGH;?></p>
                </div>
                <div class="popularity_view_listz1_liMain <?php echo $newselected;?>" data="new" onclick="change_sort_order_by_new($(this).attr('data'),'images','',$(this))">
                    <p><?php echo FS_NEWEST_FIRST;?></p>
                </div>
                <div class="popularity_view_listz1_liMain <?php if(isset($_GET["sort_order"]) && $_GET["sort_order"]!= "popularity"){ echo '';}else{echo 'choosez';}?>" data="popularity" onclick="change_sort_order_by_new($(this).attr('data'),'images','',$(this))">
                    <p><?php echo FS_POPULARITY;?></p>
                </div>
            </dd>
        </dl>
    </div>
<?php } ?>

<script type="text/javascript">
    $("#pulldownC").click(function(){
        if($("#subcategory_pulldown").is(":hidden")){
            //当前是hide状态
            $("#pulldownC").addClass('sidebar_more');
            $("#pulldownC").html('Show Less Brands');
            $("#subcategory_pulldown").slideDown();
        }else{
            //当前是show状态
            $("#pulldownC").removeClass('sidebar_more');
            $("#pulldownC").html('Show More Brands');
            $("#subcategory_pulldown").slideUp();
        }
    });

    $("#pulldownNV").click(function(){
        if($("#narrow_pulldown").is(":hidden")){
            //当前是hide状态
            $("#pulldownNV").addClass('sidebar_more');
            $("#pulldownNV").html('Show Less');
            $("#narrow_pulldown").slideDown();
        }else{
            //当前是show状态
            $("#pulldownNV").removeClass('sidebar_more');
            $("#pulldownNV").html('Show More');
            $("#narrow_pulldown").slideUp();
        }
    });
</script>
