<?php
$page_size = 20;
if (isset ( $_GET ['page_products_count'] )) {
	$page_size = $_GET ['page_products_count'];
}
$listing_split = new splitPageResults ( $new_at_fiberstore_query, $page_size, 'p.products_id', 'page' );
?><div
	class="currentPath"><a
	href="<?php
	echo zen_href_link ( FILENAME_DEFAULT );
	?>">Home</a><em>&gt;</em><span>New arrivals at FiberStore</span></div>
<div class="ProductList" style="border-top: 1px solid #CECFD1;">
<ul>            <?php
if ($listing_split->number_of_rows > 0) {
	$rows = 0;
	$listing = $db->Execute ( $listing_split->sql_query );
	$extra_row = 0;
	while ( ! $listing->EOF ) {
		$products_image = (isset ( $listing->fields ['products_image'] ) && ! empty ( $listing->fields ['products_image'] )) ? DIR_WS_IMAGES . $listing->fields ['products_image'] : DIR_WS_IMAGES . 'no_picture.gif';
		?>  		 <li>
	<p class="tc"><a
		href="<?php
		echo zen_href_link ( zen_get_info_page ( $listing->fields ['products_id'] ), 'cPath=' . zen_get_product_path ( $listing->fields ['products_id'] ) . '&products_id=' . $listing->fields ['products_id'] );
		?>"><img
		src="<?php
		echo $products_image;
		?>" width="150" height="150"
		title="<?php
		echo $listing->fields ['products_name'];
		?>"
		alt="<?php
		echo $listing->fields ['products_name'];
		?>" /></a></p>
	<p class="f10 tc"><?php
		if (isset ( $listing->fields ['products_SKU'] ) && ! empty ( $listing->fields ['products_SKU'] ))
			echo $listing->fields ['products_SKU'];
		else
			'';
		?></p>
	<div class="title"><a
		href="<?php
		echo zen_href_link ( zen_get_info_page ( $listing->fields ['products_id'] ), 'cPath=' . zen_get_product_path ( $listing->fields ['products_id'] ) . '&products_id=' . $listing->fields ['products_id'] );
		?>"
		title="<?php
		echo $listing->fields ['products_name'];
		?>"><?php
		echo $listing->fields ['products_name'];
		?></a></div>
	<div>
	<div class="f2 fl"><?php
		echo $currencies->format ( $listing->fields ['products_price'] );
		?> </div>
	<form method="post"
		action="<?php
		echo zen_href_link ( "shopping_cart", '&products_id=' . $listing->fields ['products_id'] . '&number_of_uploads=0&action=add_product', 'SSL' );
		?>">
	<div class="fr">Qty. <input name="cart_quantity" type="text"
		class="input3" value="1" /></div>
	<div class="cb"></div>
	
	</div>
	<input type="hidden" name="products_id"
		value="<?php
		echo $listing->fields ['products_id'];
		?>" />
	<div class="top5px tc "><input type="submit" class="Add"
		value="Add to Cart" /></div>
	</form>
	<p class="Favorites"><a
		href="<?php
		echo zen_href_link ( "lists", 'type=add&products_id=' . $listing->fields ['products_id'], 'SSL' );
		?>">Add
	to Favorites</a></p>
	</li>			<?php
		$listing->MoveNext ();
	}
}
?>           </ul>
<div class="cb"></div>
</div>