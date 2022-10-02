<?php
class order_info{
	function get_products_image_of_order($orders_id){
		global $db;
		$images = array();
		$sql="SELECT  op.products_id as id, p.products_image as image,pd.products_name as name

                 FROM   ".TABLE_ORDERS_PRODUCTS . " op, " . TABLE_ORDERS . " o, "  . TABLE_PRODUCTS . "  p, ".TABLE_PRODUCTS_DESCRIPTION." pd 

                 WHERE  op.products_id = p.products_id 
                 AND p.products_id = pd.products_id
                 AND o.orders_id=op.orders_id 
                 AND o.orders_id = ".$orders_id."
                 GROUP BY (op.products_id)";

		$get_images = $db->Execute($sql);
		if ($get_images->RecordCount()){
			while (!$get_images->EOF) {
				$images [] = array(
				'id' => $get_images->fields['id'],
				'image' => $get_images->fields['image'],
				'name' => $get_images->fields['name'],
				
				);
				$get_images->MoveNext();
			}
		}
		return $images;
		
	}
	
}
class my_dashboard extends order_info{

	function display_slide_of_my_dshboard($slide,$orders,$param){
		$html = "";
	
		if ($orders != null){
			$html .= '<div id="con_two_'.$slide.'" '.$param.'>
				<div class="account_order">';
			
	         foreach ($orders as $i => $order){
				 $date= strtotime($order['date_purchased']);
				 $order_data=date('m/d/Y',$date);
				$html .= '<div class="account_order_tit">
				<div class="account_tit_l">'.FIBERSTORE_ORDER_STATUS.': <span class="text_color_05">';
				if (!in_array($order['orders_status_id'], array(2,3,4,5))){
	                  	/*judge the payment method*/
	                  	/* switch (1){
	                  		case preg_match('/west/i', $order['payment_module_code']):
	                  			$href = zen_href_link(FILENAME_CHECKOUT_WESTERUNION_COMPLETE,'&orders_id='.$order['orders_id'],'SSL');
	                  			break;
	                  		case preg_match('/hsbc/i', $order['payment_module_code']):
	                  			$href = zen_href_link(FILENAME_CHECKOUT_WIRETRANSFER_COMPLETE,'&orders_id='.$order['orders_id'],'SSL');
	                  			break;
	                  		case preg_match('/paypal/i', $order['payment_module_code']):
	                  			$href = 'javascript:paypal_submit('.$order['orders_id'].');';
	                 			break;
	                  	}*/
				           $href = zen_href_link(FILENAME_CHECKOUT_PAYMENT_AGAINST,'&orders_id='.$order['orders_id'],'SSL');
	                }
	                switch ($order['orders_status_id']){
						case 1:
						case 7:
							$html .= $order['orders_status_name'];
						break;
						case 2:
						case 3:
							$html .= $order['orders_status_name'];
						break;
						case 4:
							$html .= $order['orders_status_name'];
						break;
						case 5:
							$html .= 'Canceled';
						break;
					}
					
				$html .='</span>  <span class="account_date">'.$order['date'].'&nbsp;'.$order_data.'</span></div>
                   <div class="account_tit_btn"><a href="'.zen_href_link(FILENAME_ACCOUNT_HISTORY_INFO,'&orders_id='.$order['orders_id'],'SSL').'">'.FIBERSTORE_VIEW_DETAILS.'<i class="arrow"></i></a></div>
                </div>
				
				<div class="account_order_con">
				<div id="re_picture">
				<div class="order_js">
				<div class="es-carousel-wrapper" id="carousel_'.$slide.'_'.$order['orders_id'].'">
				<div class="es-carousel">
				<ul style="width: 385px; display: block; margin-left: 0px;">';
					
					if (zen_not_null($order['products']) && sizeof($order['products'])){
				      foreach ($order['products'] as $ii => $product){
						$href = zen_href_link(FILENAME_PRODUCT_INFO,'&products_id='.$product['id']);
			      		$html .= '<li class="my_orders"><a style="border-width: 0px;" href="javascript: ;" title="'.$product['name'].'">'.zen_image(file_exists(DIR_WS_IMAGES . $product['image'])? DIR_WS_IMAGES. $product['image'] : DIR_WS_IMAGES.'no_picture.gif',$product['name'],100,100,' title="'.$product['name'].'" onclick="location=\''.$href.'\';"').'</a></li>';
				      	}
			      	}
				$href = zen_href_link(FILENAME_CHECKOUT_PAYMENT_AGAINST,'&orders_id='.$order['orders_id'],'SSL');	     
				$html .= '</ul>
				</div>
				<div class="es-nav"><span class="es-nav-prev" style="display: none;">Previous</span><span
					class="es-nav-next" style="display: none;">Next</span></div>
				</div>
				</div>
				</div>
				
				 <div class="account_order_payment">
				 <ul>
					  <li><a href="'.$href .'">'.FIBERSTORE_ORDER_NUMBER.': '.$order['orders_number'].'</a></li>
					  <li>'.FIBERSTORE_ORDER_CUSTOMER_NAME.': '.$order['customers_name'].'</li>
					  <li>'.FIBERSTORE_ORDER_TOTAL.': <span class="red">'.$order['order_total'].'</span></li>';
					  if($order['orders_status_id']==1 || $order['orders_status_id']==7){
					   $html .= '<div class="account_order_pay_btn"><a href="'.$href.'" class="line_button">'.FIBERSTORE_ORDER_PAYMENT.'<i class="security_icon_red"></i></a></div>';
				     }
				
 
					  $html .= ' </ul></div></div>';
	         }
		$html .= '</div>
				</div>';
		}else $html .= '<div id="con_two_'.$slide.'" '.$param.'>
			<div class="account_none_order">'.FIBERSTORE_DASHBOARD_NO_ORDER.'</div> </div>';
         
	return $html;
	}
	
	function display_slide_of_my_dashboard_execute($orders_query,$sql_where){
		global $db;
		$orders_query = "SELECT o.orders_id, o.customers_id,o.date_purchased, o.delivery_name,o.customers_name,
							o.delivery_name,o.delivery_lastname,o.delivery_company,o.delivery_street_address,o.delivery_suburb,
							o.delivery_city,o.delivery_postcode,o.delivery_state,o.delivery_country,o.delivery_telephone,
	                         o.billing_name, o.billing_country,
	                        ot.text as order_total, s.orders_status_name, o.orders_status, o.orders_number,o.currency,o.payment_module_code
	                 FROM   " . TABLE_ORDERS . " o, " . TABLE_ORDERS_TOTAL . "  ot, " . TABLE_ORDERS_STATUS . " s 
	                 WHERE  o.orders_id = ot.orders_id
	                 AND    o.orders_status = s.orders_status_id
	                 AND    ot.class = 'ot_total'
	                 AND    o.customers_id = :customersID
	                 AND   s.language_id = :languagesID
	                 ".$sql_where." ORDER BY orders_id DESC limit 3";
		
		$orders_query = $db->bindVars($orders_query, ':customersID', $_SESSION['customer_id'], 'integer');
		$orders_query = $db->bindVars($orders_query, ':languagesID', $_SESSION['languages_id'], 'integer');
		$get_orders = $db->Execute($orders_query);
		$orders= array();
		while(!$get_orders->EOF){
			$order_products_array = order_info::get_products_image_of_order($get_orders->fields['orders_id']);
			$orders [] = array('orders_id'=>$get_orders->fields['orders_id'],
			              'customers_id'=>$get_orders->fields['customers_id'],
			'delivery_name'=>$get_orders->fields['delivery_name'],
			'delivery_lastname'=>$get_orders->fields['delivery_lastname'],
			'delivery_company'=>$get_orders->fields['delivery_company'],
			'delivery_street_address'=>$get_orders->fields['delivery_street_address'],
			'delivery_suburb'=>$get_orders->fields['delivery_suburb'],
			'delivery_city'=>$get_orders->fields['delivery_city'],
			'delivery_postcode'=>$get_orders->fields['delivery_postcode'],
			'delivery_state'=>$get_orders->fields['delivery_state'],
			'delivery_country'=>$get_orders->fields['delivery_country'],
			'delivery_telephone'=>$get_orders->fields['delivery_telephone'],
		                  'date_purchased'=>date("Y/m/d",strtotime($get_orders->fields['date_purchased'])),
		                  'date' => date("H:i",strtotime($get_orders->fields['date_purchased'])),
		                  'customers_name' => $get_orders->fields['customers_name'],
		                  'orders_status_name'=>$get_orders->fields['orders_status_name'],
		                  'order_total'=>$get_orders->fields['order_total'],
		                  'orders_status_id' => $get_orders->fields['orders_status'],
		                  'orders_number' => $get_orders->fields['orders_number'],
		                  'currency' => $get_orders->fields['currency'],
		                  'products' => $order_products_array,
		                  'payment_module_code' => $get_orders->fields['payment_module_code']
			);
			$get_orders->MoveNext();
		}
		return $orders;
	}
	
	
function display_slide_of_my_dashboard_execute_service($orders_query,$sql_where){
		global $db;
		$orders_query = "SELECT o.orders_id, o.date_purchased, o.delivery_name,o.customers_name,
	                        o.delivery_country, o.billing_name, o.billing_country,
	                        ot.text as order_total, s.orders_status_name, o.orders_status, o.orders_number,o.currency,o.payment_module_code
	                 FROM   " . TABLE_ORDERS . " o, " . TABLE_ORDERS_TOTAL . "  ot, " . TABLE_ORDERS_STATUS . " s, ".TABLE_CUSTOMERS_SERVICE."  cs  
	                 WHERE  o.orders_id = ot.orders_id and o.orders_id = cs.orders_id 
	                 AND    o.orders_status = s.orders_status_id
	                 AND    ot.class = 'ot_total'
	                 AND    o.customers_id = :customersID
	                 AND   s.language_id = :languagesID
	                 ".$sql_where." ORDER BY orders_id DESC limit 3";
		
		$orders_query = $db->bindVars($orders_query, ':customersID', $_SESSION['customer_id'], 'integer');
		$orders_query = $db->bindVars($orders_query, ':languagesID', $_SESSION['languages_id'], 'integer');
		$get_orders = $db->Execute($orders_query);
		$orders= array();
		while(!$get_orders->EOF){
			$order_products_array = order_info::get_products_image_of_order($get_orders->fields['orders_id']);
			$orders [] = array('orders_id'=>$get_orders->fields['orders_id'],
		                  'date_purchased'=>date("Y/m/d",strtotime($get_orders->fields['date_purchased'])),
		                  'date' => date("H:i",strtotime($get_orders->fields['date_purchased'])),
		                  'customers_name' => $get_orders->fields['customers_name'],
		                  'orders_status_name'=>$get_orders->fields['orders_status_name'],
		                  'order_total'=>$get_orders->fields['order_total'],
		                  'orders_status_id' => $get_orders->fields['orders_status'],
		                  'orders_number' => $get_orders->fields['orders_number'],
		                  'currency' => $get_orders->fields['currency'],
		                  'products' => $order_products_array,
		                  'payment_module_code' => $get_orders->fields['payment_module_code']
			);
			$get_orders->MoveNext();
		}
		return $orders;
	}
		function cancel_order($order_id){
    global $db;
   // $db->Execute("update orders set orders_status = 5 where orders_id = '".$order_id."'");
}
	
	
}
