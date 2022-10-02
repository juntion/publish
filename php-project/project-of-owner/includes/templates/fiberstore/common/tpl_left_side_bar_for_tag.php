<script type="text/javascript">
var c_site = "<?php echo $_COOKIE['c_site']?>"; 
if(c_site){

}else{
	if($(window).width() < 960){
		$(".sidebar_06 dl dd").css("display","none");
	};

	$(function(){
		if($(window).width() < 960){
			$(".sidebar_06_js").toggle( 
				function(){ 
					$(".sidebar_06 dl dd").css("display","none");
				}, 
				function(){ 
					$(".sidebar_06 dl dd").css("display","block");
				} 
			);	
		};
	});
}
</script>
<div class="sidebar">

<div class="sidebar_find_left">
          <span><?php echo FIBERSTORE_TRANS1;?></span>
          <div class="sidebar_find_k"><input type="text" value="<?php echo FS_TAG_CATEGORIES_1;?>" id="C_TagAjax" style="color:#999;" onfocus="if(value=='<?php echo FS_TAG_CATEGORIES_1;?>'){this.style.color='#232323';value=''}" class="big_input" onblur="if(value==''){this.style.color='#999';value='<?php echo FS_TAG_CATEGORIES_1;?>'}"/></div>
          <span><?php echo FIBERSTORE_TRANS2;?></span>
          <div class="sidebar_find_k"><input type="text" value="<?php echo FS_TAG_CATEGORIES_2;?>" id="P_TagAjax" style="color:#999;" onfocus="if(value=='<?php echo FS_TAG_CATEGORIES_2;?>'){this.style.color='#232323';value=''}" class="big_input" onblur="if(value==''){this.style.color='#999';value='<?php echo FS_TAG_CATEGORIES_2;?>'}"/></div>
</div>


<?php 
if (!class_exists('products_narrow_by')) {
   	require DIR_WS_CLASSES.'products_narrow_by.php';
   	$products_narrow_by = new products_narrow_by();
}

if(sizeof($all_product)){
  	foreach ($all_product as $kk => $c_pro){
					$c_pids []=$c_pro['id'];
	}
}
$current_category_id = $_GET['tag'];

if(sizeof($c_pids)){
echo $products_narrow_by->fs_products_narrow_by_list_of_finder($current_category_id,$c_pids,$get_narrow);
}
?>

	<?php 
	if(sizeof($get_narrow)){
	?>
	<div class="clear_narrow">
	<i></i><a href="<?php echo zen_href_link(FILENAME_TAG_CATEGORIES,'tag='.$current_category_id);?>"><?php echo FIBERSTORE_CLEAR;?></a>
	</div>
	<?php 
	}
	?>
</div>

<script src="<?php echo HTTPS_IMAGE_SERVER;?>/includes/templates/fiberstore/jscript/fs_autocomplete.js" type="text/javascript"></script>
<script type="text/javascript">
function findValueTag(li) {
  	if( !!li.extra ) var sValue = li.extra[0];
  	else var sValue = li.selectValue;
  	var sKey = $("#C_TagAjax").val();
  	if(sValue.indexOf("http") >= 0){
  	  	window.location = sValue;
  	}
  }

  function selectItemTag(li) { findValueTag(li); }
  function formatItemTag(row) { return row[0] ; }

  function findValueTagP(li) {
	  	if( !!li.extra ) var sValue = li.extra[0];
	  	else var sValue = li.selectValue;
	  	var sKey = $("#P_TagAjax").val();
	  	if(sValue.indexOf("http") >= 0){
	  	  	window.location = sValue;
	  	}
	  }

	  function selectItemTagP(li) { findValueTagP(li); }
	  function formatItemTagP(row) { return row[0] ; }
  
var ie = !-[1,];
if(!ie){
	$("#C_TagAjax").autocomplete(
	"ajax_search_categories_tag_list.php",
      {
  		  delay:80,
		  matchSubset:1,
		  matchContains:1,
		  cacheLength:10,
		  onItemSelect:selectItemTag,
		  onFindValue:findValueTag, formatItemTag:formatItemTag
  		}
    );

	$("#P_TagAjax").autocomplete(
			"ajax_search_products_tag_list.php",
		      {
		  		  delay:80,
				  matchSubset:1,
				  matchContains:1,
				  cacheLength:10,
				  onItemSelect:selectItemTagP,
				  onFindValue:findValueTagP, formatItemTagP:formatItemTagP
		  		}
		    );
} 
</script>
