<!-- <div class="sidebar">

  <div class="sidebar_04">
		<b>Find by Network Device</b>
		<?php 
		$all_connectors = zen_get_connectors(); ?>
		<?php foreach($all_connectors as $key=>$v){ ?>
		<dl><dt><a href="<?php //echo zen_href_link(FILENAME_FIBER_CATEGORIES,'con='.$v['id']);?>"><?php //echo $v['connector'];?></a></dt></dl>
		<?php }?>
  </div>
</div> -->
<!-- <div class="sidebar sidebar_page  sidebar_hidden">
		<div class="sidebar_06"> 
            <dl class="select">
                <dt>Shop By Connectors</dt>
				<?php 
		$all_connectors = zen_get_connectors(); ?>
		<?php foreach($all_connectors as $key=>$v){ ?>

					<?php 
					if($v['id'] == $_GET['con']){
					?>

				<dd class="xiand"><a href="<?php //echo zen_href_link(FILENAME_FIBER_CATEGORIES,'con='.$v['id']);?>"><?php //echo $v['connector'];?></a></dd>

				<?php }else{ ?>

				<dd><a href="<?php echo //zen_href_link(FILENAME_FIBER_CATEGORIES,'con='.$v['id']);?>"><?php echo $v['connector'];?></a></dd>

				<?php } ?>
				<?php } ?>
			</dl>        
		</div>
</div> -->
<script src="/includes/templates/fiberstore/jscript/fs_autocomplete.js" type="text/javascript"></script>
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
