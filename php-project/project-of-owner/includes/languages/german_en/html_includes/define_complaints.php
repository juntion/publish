   <div class="currentPath"><a href="<?php echo zen_href_link(FILENAME_DEFAULT);?>">Home</a><em>&gt;</em><span>Complaints</span></div>
   
        <!--<table width="100%" border="0" cellspacing="0" cellpadding="0" class="AccountTable border">
          <tr>
            <th height="35" colspan="6" class="tl">My Complaints</th>
          </tr>
          <tr>
            <td align="center">Issue</td>
            <td width="11%" align="center">Products</td>
            <td width="8%" align="center">Type</td>
            <td width="16%" align="center">Related Order </td>
            <td width="8%" align="center">Time</td>
            <td width="20%" align="center"><span class="AccountImg">Contents</span></td>
          </tr>

          <?php
          	/*$complaints = $db->Execute("select * from ".TABLE_COMPLAINTS." where customers_id = " . $_SESSION['customer_id']);
          	if ($complaints->RecordCount() > 0)
          	{
          		while (!$complaints->EOF){

          			$products_name = $db->Execute("select products_name from " . TABLE_PRODUCTS_DESCRIPTION ." where products_id = " . $complaints->fields['products_id']);
          			$categories_name = $db->Execute("select categories_name from " . TABLE_CATEGORIES_DESCRIPTION ." where categories_id = " . $complaints->fields['categories_id']);
*/
          ?>
          	<tr>
            <td align="center"><?php //echo $complaints->fields['issue'];?></td>
            <td width="11%" align="center"><a href="<?php ///echo zen_href_link(zen_get_info_page($complaints->fields['products_id']),'products_id='.$complaints->fields['products_id'],'NONSSL');?>"><?php echo $products_name->fields['products_name'];?></a></td>
            <td width="8%" align="center"><?php //echo $categories_name->fields['categories_name'];?></td>
            <td width="16%" align="center"><?php //echo $complaints->fields['orders_number'];?></td>
            <td width="8%" align="center"><?php //echo date('m-d,Y H:i:s A',strtotime($complaints->fields['complaints_time']));?></td>
            <td width="20%" align="center"><span class="AccountImg"><?php //echo substr($complaints->fields['content'],0,20)."...";?> </span></td>
          </tr>
          <?php
          	/*		$complaints->MoveNext();
          		}
          	}*/
          	/*else
          	{*/
          ?>
           <tr>
            <td colspan="6" align="center"><span class="f2" style="color: red;"> No complaints were found!</span></td>
          </tr>
          <?php
          //	}


          ?>

          <tr>
            <td colspan="6" align="center">&nbsp;</td>
          </tr>
        </table>
        --><div class="blank10"></div>

        <form action="<?php echo zen_href_link("complaints",'','SSL');?>" method="post">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="AccountTable border">
          <tr>
            <th height="35" colspan="6" class="tl">Make a claim</th>
          </tr>
          <tr>
            <td width="11%" align="center">Products:</td>
            <td width="20%"><select name="products_id">
              <option>- Please select  -</option>
              <?php

              $products_list = $db->Execute("select tp.products_id,products_name from " . TABLE_PRODUCTS ." as tp, " . TABLE_PRODUCTS_DESCRIPTION . " as tpd where tp.products_id = tpd.products_id");
              while (!$products_list->EOF){
              	if (isset($_GET['products_id']) && $_GET['products_id'] == $products_list->fields['products_id'])
              		echo '<option selected="selected" value="'.$products_list->fields['products_id'].'">'.substr($products_list->fields['products_name'],0,20).'..'.'</option>';
  					else   	echo '<option value="'.$products_list->fields['products_id'].'">'.substr($products_list->fields['products_name'],0,20).'..'.'</option>';
              	$products_list->MoveNext();
              }?>

            </select></td>
            <td width="8%" align="center">Type</td>
            <td width="20%"><select name="categories_id">
              <option>- Please select  -</option>
               <?php
               if (isset($_GET['products_id'])) {
               		$get_categories_id = $db->Execute("select * from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = " . $_GET['products_id']);
               		$categories_id = $get_categories_id->fields['categories_id'];
               }
              $categories_list = $db->Execute("select tc.categories_id,categories_name from " . TABLE_CATEGORIES ." as tc, " . TABLE_CATEGORIES_DESCRIPTION . " as tcd where tc.categories_id = tcd.categories_id");
              while (!$categories_list->EOF){
              	if (isset($_GET['products_id']) && $categories_id == $categories_list->fields['categories_id'])
              	echo '<option selected="selected" value="'.$categories_list->fields['categories_id'].'">'.substr($categories_list->fields['categories_name'],0,20).'...'.'</option>';

              	else echo '<option value="'.$categories_list->fields['categories_id'].'">'.substr($categories_list->fields['categories_name'],0,20).'...'.'</option>';
              	$categories_list->MoveNext();
              }?>
            </select></td>
            <td width="15%" align="center">Related Order: </td>
            <td width="26%"> <input name="related_order_id" type="text" class="input1" <?php if (isset($_GET['products_id']) && !empty($_GET['orders_number'])) echo ' value="'.$_GET['orders_number'].'"';?> /></td>
          </tr>
          <tr>
          	<td align="center">Issue:</td>
            <td colspan="5"><input name="issue" type="text" class="input" style="width:415px;" /></td>
          </tr>
          <tr>
          	<td align="center">Content:</td>
            <td colspan="5"><textarea name="content" cols="80" rows="5"></textarea></td>
          </tr>
          <tr>
            <td colspan="6" align="center">
              <input type="submit" value="Submit" class="btn5" />
            </td>
          </tr>
        </table></form>
