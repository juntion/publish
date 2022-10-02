<?php
require('includes/application_top.php');

$action = $_GET['action'];

//load products_narrow_by class
require DIR_WS_CLASSES . 'products_narrow_by.php';
$products_narrow_by = new products_narrow_by();

require DIR_WS_CLASSES . 'fiberstore_banner.php';
$fiberstore_banner = new fiberstore_banner();

if (zen_not_null($action)){
	switch($action){
		//get narrow by options by category id
		case 'ajax_get_current_category_options':
			$cID = (int)$_POST['cID'];
			$level_id = $_POST['level_id'];
			
			$option_names = $products_narrow_by->get_options_name_tree($cID);
			
			if (!sizeof($option_names)) {
				$option_names = $products_narrow_by->get_options_name_tree();
			}
			
			echo zen_draw_pull_down_menu('narrowByOptions', $option_names, 'xxx',' multiple="multiple" size="20" id="narrowByOptions" style="vertical-align:top;cursor:pointer;width:300px;"');
			exit;
			break;
		//get sub categories or products by category id
		case 'ajax_get_categories_or_products':
			$cID = (int)$_POST['cID'];
			$level_id = $_POST['level_id'];
			if(!zen_category_has_sub_category($cID)){
				
				//get narrow by which has been append to this category 
				$options = $products_narrow_by->get_category_own_options($cID);
				
				$products = zen_get_categories_products($cID);
				$count = sizeof($products);
				if ( $count) {
					$str = '<br/><br/>';
					$str .= '<table class="table table-hover table-condensed table-bordered" id="products">';
					 
					$str .= '<tr>';
					//$str .= '<th><label for="checkAll"><input type="checkbox" id="checkAll" onclick="check_All(this.id);"/> 全选</label> </th>';
					$str .= '<th align="center" width="98%">产品名称</th>';

					//set option name as table title
					foreach ($options as $i => $option_id){
						//$str .= '<th>'.$products_narrow_by->get_option_name($option_id).'</th>';
					}
					
					$str .= '</tr>';
						
					$categories_banner_html = '';
					
					foreach ($products as $ii => $product){
						$str .= '<tr>';

						$str .= '<td width="45%" align=""> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_'.$product['id'].'">'.$product['text'].$ii.'</a>
						
								<div id="collapse_'.$product['id'].'" class="accordion-body collapse">
   
'.zen_draw_input_field(''.$product['id'].'_image[]','', 'placeholder="name"').'    					
								'.zen_draw_input_field(''.$product['id'].'_link[]','', 'placeholder="reviews"','size="30"').'<br>
'.zen_draw_input_field(''.$product['id'].'_image[]','', '').'
    							'.zen_draw_input_field(''.$product['id'].'_link[]','', 'class').'<br>
'.zen_draw_input_field(''.$product['id'].'_image[]','', '').'
    							'.zen_draw_input_field(''.$product['id'].'_link[]','', 'class').'<br>
'.zen_draw_input_field(''.$product['id'].'_image[]','', '').'
    							'.zen_draw_input_field(''.$product['id'].'_link[]','', 'class').'<br>
'.zen_draw_input_field(''.$product['id'].'_image[]','', '').'
    							'.zen_draw_input_field(''.$product['id'].'_link[]','', 'class').'<br>
'.zen_draw_input_field(''.$product['id'].'_image[]','', '').'
    							'.zen_draw_input_field(''.$product['id'].'_link[]','', 'class').'<br>

						</div>
								</td>';

						
						$str .= '</tr>';
					}
					
					$str .= '</table>';
					
					
					echo $str;
				}else {
						
					echo '<b style="color:red;">当前分类没有子分类或产品 !</b>';
				}
			}else{
				$categories = array_merge(array(array('id'=>0,'text'=>'请选择分类')),zen_get_narrow_by_categories($cID));
				
				$current_select_id = 'level_'.((int)substr($level_id, strpos($level_id, '_')+1)+1);
				echo zen_draw_pull_down_menu('categories[]',$categories,$cID,' id="'.$current_select_id.'" style="vertical-align:top;cursor:pointer;" onchange="ajax_get_categories_or_products(this.value,this.id);"');
			}
				
			exit;
			break;
		case 'ajax_get_products':
			$cID = $_POST['cID'];
			// if this category contains products
			if(!zen_category_has_sub_category($cID)){
				$products = zen_get_categories_products($cID);
				$count = sizeof($products);
				if ( $count) {
					echo zen_draw_pull_down_menu('products[]',$products,$products_id,' size="10" multiple="multiple" id="products" style="vertical-align:top;cursor:pointer;"');
				}else {
					
					echo '<b style="color:red;">当前分类没有子分类或产品 !</b>';
				}
			}else 
				echo '<h2 style="color:red;">当前分类包含子分类，请选择包含产品的子分类 !</h2>';
			
			exit;
			break;
			
			//获取需要添加banner图产品ID号
		case 'get_banner_by_products_ids':
			$cPath = $_POST['cPath'];
			$cID = $_POST['categories'];
			//die($cID);
			$pID = $cID[sizeof($cID)-1];
			$products = zen_get_categories_products($pID);
			//var_dump($products);exit();

			$count = sizeof($products);
			if ( $count) {
				$link []= array();
				//echo zen_draw_pull_down_menu('products[]',$products,'',' size="10" multiple="multiple" id="products" style="vertical-align:top;cursor:pointer;"');
				for ($i=0;$i<$count;$i++){
					$picture_name = zen_get_products_name_banner($products[$i]['id']);

					$link [] = array('id' => $products[$i]['id'],
								'link' => $_POST[''.$products[$i]['id'].'_link'],
								'image' => $_POST[''.$products[$i]['id'].'_image']
								);
				}
				for ($i=0,$n = count($link);$i<$n;$i++) {
					if($link[$i] != null)	{
						$link_arr = $link[$i]['link'];
						$cid_arr = $link[$i]['id'];
						$image_arr = $link[$i]['image'];
						for($j=0,$k=sizeof($link_arr);$j<$k;$j++) {
						if($image_arr[$j]){
								$sql = "insert into ".TABLE_REVIEWS." (products_id,customers_name,reviews_rating,date_added) values ('".$cid_arr."','".$image_arr[$j]."',5,now())";
								$db->Execute($sql);
								$a_id = $db->insert_ID();
//								$sql_comments = "insert into ".REVIEWS_COMMENTS." (reviews_id,products_id,status) values ('".$a_id."','".$cid_arr."',1)";
//								$db->Execute($sql_comments);
								$sql_description = "insert into ".TABLE_REVIEWS_DESCRIPTION." (reviews_id,languages_id,reviews_text) values ('".$a_id."',1,'".$link_arr[$j]."')";
								
								$db->Execute($sql_description);
						}
						}
					}
				}
         	$messageStack->add_session('添加成功  !','success');	
	        zen_redirect(zen_href_link('doc_reviews_batch_upload.php','','NONSSL'));
				
			}else  echo '<b style="color:red;">当前分类没有子分类或产品 !</b>';
			
			exit;
			break;
			
	}
}

//get top level  categories
$root_categories = array_merge(array(array('id'=>0,'text'=>'请选择分类')),zen_get_narrow_by_categories());
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<meta name="robot" content="noindex, nofollow" />

<link href="includes/stylesheet.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS" />
<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.9.1.custom.min.css" media="all"  />

<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<script type="text/javascript">
function check_All($id){
		if($('#'+$id).is(':checked')){
			$('input[name="products[]"]').each(function(){
				//alert($(this).val);
				$(this).attr('checked','checked');
				});
		}else{
			$('input[name="products[]"]').each(function(){
				$(this).removeAttr('checked');
				});
		}
	}	
</script>

</head>
<body >
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->


<h4>产品评论批量管理</h4>


<?php echo zen_draw_form('banner_form','doc_reviews_batch_upload.php','action=get_banner_by_products_ids','post',' id="banner_form" ');?>

  
  <table width="100%"  border="0" cellspacing="0" cellpadding="0"  style="border-color:lightblue">
  <tr>
      <th valign="top" align="right" scope="col">
       <button class="btn  " type="submit" onClick="ajax_get_products_ids(<?php echo (int)$_POST['cID'];?>);">Update</button>
      <?php //echo zen_image_submit('button_insert.gif',IMAGE_INSERT);?></th>
    </tr>
    <tr >
      <th scope="col" id="ny_categories" align="left">
        <?php 
    echo  '分类: ' . zen_draw_pull_down_menu('cPath', $root_categories, $current_category_id,' id="level_1" id="cPath" onchange="ajax_get_categories_or_products(this.value,this.id);"  style="vertical-align:top;cursor:pointer;" ');
  ?>
        </th>
    </tr>

     <tr>
      <th valign="bottom" align="right" scope="col"><br>
      <button class="btn  " type="submit">Update</button>
      <?php //echo zen_image_submit('button_insert.gif',IMAGE_INSERT);?></th>
    </tr>

  </table>
  <p>&nbsp;</p>
</form>

<p class="footer_height"></p>
<!-- body_eof //-->
<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>


<script type="text/javascript" src="js/general.js"></script>
<script language="javascript" src="js/jquery-1.9.1.js"></script>
<script language="javascript" src="js/bootstrap.js"></script>

<script type="text/javascript">

function ajax_get_categories_or_products(cID,level_id){
	 $('#'+level_id).nextAll().remove();
	if(cID > 0){
		$.ajax({
			   type: "POST",
			   url: "doc_reviews_batch_upload.php?action=ajax_get_categories_or_products",
			   data: "cID="+cID+"&level_id="+level_id,
			   success: function(data){
// 			   alert(data);return false;
			     $("#ny_categories").append(data);

			     //get current category options
			     if(-1 != data.indexOf('table')){
				     $.ajax({
						   type: "POST",
						   url: "doc_reviews_batch_upload.php?action=ajax_get_current_category_options",
						   data: "cID="+cID+"&level_id="+level_id,
						   success: function(data){
						     $("#narrowByOptions").replaceWith(data);
	
						     
						   }
						});
			     }
			   }
			}); 
		}
}

function ajax_get_products(cID){
	$.ajax({
		   type: "POST",
		   url: "doc_reviews_batch_upload.php?action=ajax_get_products",
		   data: "cID="+cID,
		   success: function(data){
//		   alert(data);return false;
		     $("#products_list").html(data);
		   }
		}); 
}
function ajax_get_optionValues(oID){
	$.ajax({
		   type: "POST",
		   url: "doc_reviews_batch_upload.php?action=ajax_get_optionValues",
		   data: "oID="+oID,
		   success: function(data){
//		   alert(data);return false;
		     $("#optionValuesList").html(data);
		   }
		}); 
}

//function ajax_get_products_ids(cID){
//	alert(cID);
//}

</script>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>