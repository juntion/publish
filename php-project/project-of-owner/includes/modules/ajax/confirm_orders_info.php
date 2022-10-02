<?php
if (isset($_GET['ajax_request_action']) && $_GET['ajax_request_action']){
	
  $action = $_GET['ajax_request_action'];

  if(!zen_not_null($action)){
	echo "err";
  }else{
	switch($_GET['ajax_request_action']){
		case 'storeHttpReferers':

			if(isset($_POST['orders_id'])){
				$main_order_id = fs_get_data_from_db_fields('main_order_id','orders','orders_id='.$_POST['orders_id'],'limit 1');
				$flag = true;
				if(!in_array($main_order_id,array(0,1))){
					$son_res = $db->Execute("select orders_id,orders_status from orders where main_order_id=".$main_order_id." and orders_id!=".$_POST['orders_id']);
					while(!$son_res->EOF){
						if($son_res->fields['orders_status']!=4){
							$flag = false;break;
						} 
						$son_res->MoveNext();
					}
				}else{
					$flag = false;
				}
				$sql = "update ".TABLE_ORDERS." set orders_status = 4,mark=0 where orders_id = ".$_POST['orders_id']."";
				$db->query($sql); 
				if($flag){$db->Execute("update ".TABLE_ORDERS." set orders_status = 4,mark=0 where orders_id = ".$main_order_id."");}

				$his_sql = "insert into " . TABLE_ORDERS_STATUS_HISTORY . " (orders_id, orders_status_id, date_added ,comments)
	            		   values ('".$_POST['orders_id']."', '4', now(),'Thank you for your shopping in fiberstore, waiting for your next visiting.')";
				
				$db->Execute($his_sql); 
				
				exit('ok');
			}
			break;

        case 'storeHttpReferers_new':
            include(DIR_WS_CLASSES . 'order.php');

            if (empty($_SESSION['customer_id'])) {
                exit(json_encode(array('status' => -1, 'info' => FS_ACCESS_DENIED, 'data' => '', 'href' => zen_href_link('login'))));
            }
            $_POST['orders_id'] = $orders_id = $_POST['orders_id']?(int)zen_db_prepare_input($_POST['orders_id']):0;
            if(!$orders_id){
                exit(json_encode(array('status' => 0, 'info' => FS_ACCESS_DENIED, 'data' => '')));
            }

            // 该用户有权限查看的所有订单
            $orders_arr = get_customer_can_visit_orders();
            // 不是自己的订单，没有权限查看
            if(!in_array($orders_id,$orders_arr)){
                exit(json_encode(array('status' => 0, 'info' => FS_ACCESS_DENIED, 'data' => '')));
            }

            $main_order_id = fs_get_data_from_db_fields('main_order_id','orders','orders_id='.$_POST['orders_id'],'limit 1');
            if($main_order_id==1){ //如果是有分单的主单，不能确认收货
                exit(json_encode(array('status' => 0, 'info' => FS_ACCESS_DENIED, 'data' => '')));
            }
            //该订单的子单（除了当前订单）是否全部已收货
            $flag = true;
            if(!in_array($main_order_id,array(0,1))){
                $son_res = $db->Execute("select orders_id,orders_status from orders where main_order_id=".$main_order_id." and orders_id!=".$_POST['orders_id']);
                while(!$son_res->EOF){
                    if($son_res->fields['orders_status']!=4){
                        $flag = false;break;
                    }
                    $son_res->MoveNext();
                }
            }else{
                $flag = false;
            }
            $sql = "update ".TABLE_ORDERS." set orders_status = 4,mark=0 where orders_id = ".$_POST['orders_id']."";
            $db->query($sql);

            if($flag){
                $db->Execute("update ".TABLE_ORDERS." set orders_status = 4,mark=0 where orders_id = ".$main_order_id."");
            }

            //给客户发送评论邀约邮件
            $check_status = $db->Execute("select customers_name, customers_email_address,orders_number, orders_status,customers_id,language_code,language_id,
                                      date_purchased,payment_module_code,customers_po,purchase_order_num,main_order_id,is_test from " . TABLE_ORDERS . "
                                      where orders_id = '" . (int)$_POST['orders_id'] . "'");
            send_customer_and_admin_reviews_email(array(
                'orders_id' => (int)$_POST['orders_id'],
                'language_code' => $check_status->fields['language_code'],
                'customers_id' => $check_status->fields['customers_id'],
                'customers_name' => $check_status->fields['customers_name'],
                'order_number' => $check_status->fields['orders_number'],
                'language_id' => $check_status->fields['language_id'],
            ));

            $his_sql = "insert into " . TABLE_ORDERS_STATUS_HISTORY . " (orders_id, orders_status_id, date_added ,comments)
                       values ('".$_POST['orders_id']."', '4', now(),'Thank you for your shopping in fiberstore, waiting for your next visiting.')";

            $db->Execute($his_sql);
            exit(json_encode(array('status' => 1, 'info' => F_RECEIPT_CONFIRMATION_SUCCESS_TIP, 'data' => '')));

            break;

		case 'order_tracking_info':
			$orders_id = $_POST['orders_id'];
			$tracking_order_id = $_POST['tracking_order_id'];
			$tracking_html = '';
			$statusArray = array();
			$statusArray = zen_get_order_all_status($orders_id);
			
			if($orders_id && $tracking_order_id){
				$tracking = fs_get_data_from_db_fields_array(array('shipping_method','tracking_number','products_instock_id'),'order_tracking_info','order_tracking_id='.$tracking_order_id,'limit 1');
				$method  = $tracking[0][0];
				$num = $tracking[0][1];
				$productsInstockId = $tracking[0][2];
				switch ($method) {
					case 'Fedex':
					case 'FEDEX IP':
					case 'FEDEX IE':
						$shipping_com = FS_METHOD.': <a target="_blank" style="color:#a10000;" href="https://www.fedex.com/fedextrack/">Fedex</a>&nbsp;&nbsp;&nbsp;<br>'.SALES_DETAILS_TRACKING.':  '.$num.' ';
						break;
					case 'DHL':
						$shipping_com = FS_METHOD.': <a target="_blank" style="color:#a10000;" href="http://www.dhl.com/en/express/tracking.html">DHL</a>&nbsp;&nbsp;&nbsp;'.SALES_DETAILS_TRACKING.':  '.$num.' ';
						break;
					case 'AIRMAIL':
						$shipping_com = FS_METHOD.': <a target="_blank" style="color:#a10000;" href="http://app3.hongkongpost.com/CGI/mt/enquiry.jsp">AIRMAIL</a>&nbsp;&nbsp;&nbsp;'.SALES_DETAILS_TRACKING.': '.$num.' ';
						break;
					case 'EMS':
						$shipping_com = FS_METHOD.': <a target="_blank" style="color:#a10000;" href="http://www.ems.com.cn/english.html">EMS</a>&nbsp;&nbsp;&nbsp;'.SALES_DETAILS_TRACKING.': '.$num.' ';
						break;
					case 'USPS':
					case 'UPS':
					case 'UPS Ground':
						$shipping_com = FS_METHOD.': <a target="_blank" style="color:#a10000;" href="https://www.usps.com/">USPS</a>&nbsp;&nbsp;&nbsp;'.SALES_DETAILS_TRACKING.': '.$num.' ';
						break;
					case 'TNT':
						$shipping_com = FS_METHOD.': <a target="_blank" style="color:#a10000;" href="http://www.tnt.com/express/en_ca/site/home.html">TNT</a>&nbsp;&nbsp;&nbsp;'.SALES_DETAILS_TRACKING.': '.$num.' ';
						break;
				}
				$tracking_html .= '<table width="100%" border="0" cellspacing="0" cellpadding="0">
									  <tr>
										<th class="text_left" width="20%">Processing Time</th>
										<th class="text_left">Process Information</th>
										<th class="text_left" width="20%">Process Operator</th>
									  </tr>';
				if($statusArray){
					foreach ($statusArray as $status){
						if($status['id'] == 3){
							$shipping_comments = $shipping_com;
						}
						if($status['id'] == 1){
							$pro_info = MY_ORDER_SUCCESSFULLY;
						}else if($status['id'] == 2){
							$pro_info = MY_ORDER_WAIT;
						}else $pro_info = $status['orders_status_name']. FIBERSTORE_BY_SYSTEM;
						$tracking_date = date("Y-m-d H:i:s",strtotime($status['date_added']));
						$tracking_info = ($shipping_comments) ? $shipping_comments : $pro_info;
						$admin = ($status['admin_id']) ? zen_get_admin_name_of_id($status['admin_id']) : FIBERSTORE_SESTEM;
						$tracking_html .= '<tr>
								<td>'.$tracking_date.'</td>
								<td>'.$tracking_info.'</td>
								<td>'.$admin .'</td>
							  </tr>';
						if($status['id'] == 3){
							$tracking_info = fs_order_shipping_info_kuaidi100($method, $num);
							$tracking_html .= '<tr><td colspan="2">'.$tracking_info['data'].'</td><td>'.$method.'</td></tr>';
						}
					}
				}
				
				$tracking_html .= '</table>';
			}
			echo  $tracking_html;
			exit;
		break;
		case 'check_order':
			$order_number = trim($_POST['order_number']);
			//echo $order_number;exit;
			$order_number = zen_db_prepare_input($order_number);
			$order_id = fs_get_data_from_db_fields('orders_id','orders','orders_number like "'.$order_number.'"','limit 1');
			$status = false;
			$typeHtml = '';
			if($order_id){
				$order_time = fs_get_data_from_db_fields('date_purchased','orders','orders_id='.(int)$order_id,'limit 1');
				if($order_time){
					$order_time = strtotime($order_time)+(86400*40);
					if($order_time<time()){
						$status = true;
					}
				}
				
			}
			if($status){
				$typeHtml = '<select class="big_input input100 " name="reason_type" id="reason_type">
							  <option value="0">Please Select...</option>
							  <option value="2">Replacement</option>
							  <option value="3">Maintenance</option>
							</select>';
			}else{
				$typeHtml = '<select class="big_input input100 " name="reason_type" id="reason_type">
							  <option value="0">Please Select...</option>
							  <option value="1">Return & Refund</option>
							  <option value="2">Replacement</option>
							  <option value="3">Maintenance</option>
							</select>';
			}
			$data = array("status"=>$status,"order_id"=>$order_id,"time"=>$order_time,"nTime"=>time(),"html"=>$typeHtml);
			echo json_encode($data);
			exit;
		break;
		case 'reorder_products':
			$orders_id = $_POST['orders_id'];
			$action = $_POST['action'];
			$son_order = array();
			if($orders_id){
				$son_order = zen_get_all_son_order_id($orders_id);
				if(!count($son_order)){
					$son_order[] = $orders_id;
				}
				$all_products = array();
				foreach($son_order as $k=>$id){
					$products = zen_get_all_reorder_products($id);
					$all_products = array_merge($all_products,$products);
				}
				$allNum = sizeof($all_products);
				$closePro = $customPro = $normalPro = array();
				$closeNum = $customNum = $normalNum = $type = 0;
				$closeHtml = $customHtml = $html = '';
				if($allNum){
				  foreach($all_products as $product){
					if($product['id']){
					    $status = get_product_status($product['id']);
					  if($status==0){
						//关闭产品
						$closePro[] = $product;
					  }else{
						//未关闭的产品，区分是否是定制产品
						$column_id = fs_get_data_from_db_fields('column_id','attribute_custom_column','column_name = "' . (int)$product['id']. '" and parent_id = 0','limit 1');
						if($column_id){
						  $customPro[] = $product;   
						}else{
						  $lenStatus = false;
						  if(sizeof($product['attribute'])){
							reset($product['attribute']);
							while (list($option, $value) = each($product['attribute'])){
								if($option == 'length'){
									if(!$value){$lenStatus = true;break;}
								}else{
									$attrRes = $db->Execute("select products_attributes_id from products_attributes where products_id={$product['id']} and options_id={$option} and options_values_id={$value}");
									if(!$attrRes->fields['products_attributes_id']){
										$lenStatus = true;break;
									}
								}
							}
						  }
						  if($lenStatus){
							$customPro[] = $product;     
						  }else{
							$normalPro[] = $product;   
						  }
						}
					  }
					}
				  }
				  $closeNum = count($closePro);
				  $customNum = count($customPro);
				  $normalNum = count($normalPro);
				  if($closeNum==0 && $customNum==0){
					$type = 1;  // 可以整单直接加入购物车
					foreach($normalPro as $pro){
					  $qty = $_SESSION['cart']->get_quantity(zen_get_uprid($pro['id'], $pro['attribute']))+$pro['qty'];
					  $_SESSION['cart']->add_cart($pro['id'], $qty, $pro['attribute']);
					}  
				  }else{ 
					if($normalNum==0){
					  // 整单的产品都是关闭产品或者定制产品
					  $type = 2;
					}else{
					  //部分产品可以加入购物车  
					  $type = 3;
					  if($action==2){
						foreach($normalPro as $pro){
						  $qty = $_SESSION['cart']->get_quantity(zen_get_uprid($pro['id'], $pro['attribute']))+$pro['qty'];
						  $_SESSION['cart']->add_cart($pro['id'], $qty, $pro['attribute']);
						}   
					  }
				    }
					if($closeNum){
					  $closeHtml .= '<div class="over_padding_f">
							<h2 class="over_top_tit">'.FS_COMMON_REORDER_CLOSE.'</h2>
							<div class="over_top_div">';  
					  foreach($closePro as $pro){
						$image = fs_get_data_from_db_fields('products_image',TABLE_PRODUCTS,'products_id='.$pro['id'],'limit 1');
						$image_src= file_exists(DIR_WS_IMAGES.$image) ? DIR_WS_IMAGES.$image: DIR_WS_IMAGES.'no_picture.gif';
						$closeHtml .= '<dl class="over_top_dl001">
								<dt><img src="'.HTTPS_IMAGE_SERVER.$image_src.'" /></dt>
								<dd>'.$pro['name'].'<em>'.MANAGE_ORDER_QTY.': '.$pro['qty'].'</em></dd>
							</dl>';  
					  }	
					  $closeHtml .= '</div></div>';  
					}
					if($customNum){
					  $customHtml .= '<div class="over_padding_f">
							<h2 class="over_top_tit">'.FS_COMMON_REORDER_CUSTOM.'</h2>
							<div class="over_top_div">';  
					  foreach($customPro as $pro){
						$image = fs_get_data_from_db_fields('products_image',TABLE_PRODUCTS,'products_id='.$pro['id'],'limit 1');
						$image_src= file_exists(DIR_WS_IMAGES.$image) ? DIR_WS_IMAGES.$image: DIR_WS_IMAGES.'no_picture.gif';
						$customHtml .= '<dl class="over_top_dl001">
								<dt><img src="'.HTTPS_IMAGE_SERVER.$image_src.'" /></dt>
								<dd>'.$pro['name'].'<em>'.MANAGE_ORDER_QTY.': '.$pro['qty'].'</em></dd>
							</dl>';  
					  }	
					  $customHtml .= '</div></div>';  
					}
					$html .= $closeHtml.$customHtml;
					if($type==2){
					  $html .= '<div class="over_bottom_btn001" onclick="$(\'#ProductsAttributes,.ui-widget-overlay,#fs_cart_overlay\').hide();$(\'#addproductsinfo\').html(\'\');$(\'.transform_fs\').text(reorderName);$(\'.transform_fs\').removeClass(\'transform\');"><button class="over_btn_002">'.FS_SHIP_CONFIRM.'</button></div>';
					}else{
					  $html .= '<div class="over_bottom_btn001">
							<button class="over_btn_001" onclick="$(\'#ProductsAttributes,.ui-widget-overlay,#fs_cart_overlay\').hide();$(\'#addproductsinfo\').html(\'\');$(\'.transform_fs\').text(reorderName);$(\'.transform_fs\').removeClass(\'transform\');">Cancel</button>
							<button class="over_btn_002" onclick="restore_order_products('.$orders_id.',2)">'.FS_COMMON_REORDER_SKIP.'</button>
						</div>';
					}
				  }
				}
				$data = array('type'=>$type,'html'=>$html);
				echo json_encode($data);
			}else{
				echo 'err';
			}
			exit;
		break;

        case 'reorder_products_new': //2018.12.07 个人中心进行改版，新版reorder使用这个
            $orders_id = $_POST['orders_id']?zen_db_prepare_input($_POST['orders_id']):'';
            $orders_products_id = $_POST['orders_products_id']?zen_db_prepare_input($_POST['orders_products_id']):'';
            $action = $_POST['action']?zen_db_prepare_input($_POST['action']):'';
            require_once(DIR_WS_CLASSES.'shipping_info.php');
            if($orders_id || $orders_products_id){
                if($orders_products_id){ //单个产品价格购物车
                    $all_products = zen_get_all_reorder_products('',$orders_products_id);
                }else{
                    $son_order = array();
                    $son_order = zen_get_all_son_order_id($orders_id);
                    if(!count($son_order)){
                        $son_order[] = $orders_id;
                    }
                    $all_products = array();
					if(sizeof($son_order)){
						$order_reissue = [];
						$res=$db->Execute("select orders_id,is_reissue from orders where orders_id in (".join(',',$son_order).")");
						while(!$res->EOF){
							$order_reissue[$res->fields['orders_id']] = $res->fields['is_reissue'];
							$res -> MoveNext();
						}
						foreach($son_order as $k=>$id){
							if(!in_array($order_reissue[$id],[22,23])){
								//赠品单产品不获取
								$products = zen_get_all_reorder_products($id);
								$all_products = array_merge($all_products,$products);
							}
						}
					}
                }
                $allNum = sizeof($all_products);
                $closePro = $customPro = $normalPro = array();
                $closeNum = $customNum = $normalNum = $type = 0;
                $closeHtml = $customHtml = $html = '';
                $customPro = [];
                $clePro = [];
                $NoClePro = [];
                if($allNum){
                    foreach($all_products as $product) {
                        if ($product['id']) {
                            $status = get_product_status($product['id']);
                            if ($status == 0) {
                                //关闭产品
                                $closePro[] = $product;
                            } else {
                                //未关闭的产品，区分是否是定制产品
                                $column_id = fs_get_data_from_db_fields('column_id', 'attribute_custom_column', 'column_name = "' . (int)$product['id'] . '" and parent_id = 0', 'limit 1');
                                //清仓产品加购限制
                                $is_clearance = get_current_pid_if_is_clearance($product['id']);
                                if($is_clearance){
                                    $config['pid'] = $product['id'];
                                    $shippingInfo = new ShippingInfo($config);
                                    $clearance_qty = $shippingInfo->getLocalAndWuhanqty(); //清仓产品总库存
                                    $un_qty = $product['qty'];
                                    $cart_pid_qty = 0;
                                    if($_SESSION['cart']->in_cart($product['id'])){
                                        $cart_pid_qty = $_SESSION['cart']->contents[$product['id']]['qty'];//加购数量
                                        $un_qty = $cart_pid_qty + $product['qty']; //客户多次点击再次购买或者购物车中存在该产品
                                    }
//                                    if(($cart_pid_qty == $clearance_qty && $clearance_qty) || $clearance_qty==0){
//                                        $clePro[$product['id']] = $product;//清仓产品
//                                        unset($product);
//                                    }

                                    if($un_qty>$clearance_qty || $clearance_qty==0){
                                        $product['total_qty'] = $clearance_qty;//清仓产品库存
                                        $product['is_clearance'] = 1;
                                        $product['cart_pid_qty'] = $cart_pid_qty; //购物车中该产品数量
                                        if($clearance_qty && $cart_pid_qty<=$clearance_qty){
                                            $product['qty'] = $clearance_qty-$cart_pid_qty;
                                            $clePro[] = $product;//超限清仓产品
                                        }
                                        if($clearance_qty==0){
                                            $product['qty'] = 0;
                                            $NoClePro[] = $product;//无库存清仓产品
                                        }
                                        if($clearance_qty==0 || $product['qty']==0){
                                            unset($product);
                                        }
                                    }
                                }
                                if ($column_id) {
                                    $customPro[] = $product;
                                } else {
                                    $lenStatus = false;
                                    if (sizeof($product['attribute'])) {
                                        reset($product['attribute']);
                                        while (list($option, $value) = each($product['attribute'])) {
                                            //客户自己填写的内容 value_id 都是0  key格式是文字 [text_prefix_option_id]
                                            //   附件 [upload_prefix_option_id]
                                            if (strpos($option, 'upload_prefix_') !== false) {
                                                $option = substr($option, strlen('upload_prefix_'));
                                                $value = PRODUCTS_OPTIONS_VALUES_TEXT_ID;
                                            }
                                            if (strpos($option, TEXT_PREFIX) !== false) {
                                                $option = substr($option, strlen(TEXT_PREFIX));
                                                $value = PRODUCTS_OPTIONS_VALUES_TEXT_ID;
                                            }
                                            if ($option == 'length') {
                                                if (!$value) {
                                                    $lenStatus = true;
                                                    break;
                                                }
                                            } else {
                                                if(is_array($value)){
                                                    foreach ($value as $kk=>$attr){
                                                        $attrRes = $db->Execute("select products_attributes_id from products_attributes where products_id={$product['id']} and options_id={$option} and options_values_id={$attr}");
                                                        if (!$attrRes->fields['products_attributes_id']) {
                                                            $lenStatus = true;
                                                            break;
                                                        }
                                                    }
                                                }else{
                                                    $attrRes = $db->Execute("select products_attributes_id from products_attributes where products_id={$product['id']} and options_id={$option} and options_values_id={$value}");
                                                    if (!$attrRes->fields['products_attributes_id']) {
                                                        $lenStatus = true;
                                                        break;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    if ($lenStatus) {
                                        $customPro[] = $product;
                                    } else {
                                        if($product){
                                            $normalPro[] = $product;/*清仓产品加购超限,避免加入到常规产品中*/
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $cleProNum = count($clePro);//超限清仓产品
                    $NoCleProNum = count($NoClePro);//无库存清仓产品
                    $closeNum = count($closePro);
                    $customNum = count($customPro);
                    $normalNum = count($normalPro);
                    $topCartHtml = '';  //产品加购成功，需要更新头部购物车
                    if($closeNum==0 && $customNum==0 && $cleProNum==0 && $NoCleProNum==0){
                        $type = 1;  // 可以整单直接加入购物车
                        foreach($normalPro as $pro){
                            $_SESSION['cart']->add_cart($pro['id'], $pro['qty'], $pro['attribute']);
                        }
                        $html = products_add_cart_new_popup(false,'','buy_again');
                        $cart_items = $_SESSION['cart']->count_contents();
                        require_once DIR_WS_CLASSES.'shopping_cart_help.php';
                        $shopping_cart_help = new shopping_cart_help();
                        $topCartHtml = $shopping_cart_help->show_cart_products_block($cart_items);
                    }else{
                        if($normalNum==0 ){
                            // 整单的产品都是关闭产品或者定制产品
                            $type = 2;
                        }else{
                            //部分产品可以加入购物车
                            $type = 3;
                            if($action==2){
                                foreach($normalPro as $pro){
                                    $_SESSION['cart']->add_cart($pro['id'], $pro['qty'], $pro['attribute']);
                                }
                            }
                        }
                        if($closeNum || $cleProNum || $NoCleProNum){
                            //2019.2.26 pico 下架商品弹窗价格展示
                            $son_order_ids = $db->getAll("select orders_id from orders where main_order_id={$_POST['orders_id']}");
                            $disabled = '';
                            $choosez = '';
                            $close_clear_pro = array_merge($closePro,$clePro);
                            $close_clear_pro = array_merge($close_clear_pro,$NoClePro);
                            $unque_pid = [];
                            foreach($close_clear_pro as $kk => $pro){
                                if(!in_array($pro['id'],$unque_pid) && $pro['id']){ //针对相同产品ID分单的清仓产品去重数组
                                    $is_show_qty = false;
                                    $offline_no_stock = '';
                                    if(empty($pro['is_clearance'])){
                                        //关闭产品
                                        $off_html = '<div class="dash_wenhao"><div class="track_orders_wenhao">
                                                                    <i class="iconfont icon">&#xf228;</i>
                                                                    <div class="question_text_01 leftjt">
                                                                        <div class="arrow"></div>
                                                                        <div class="popover-content">'.FS_PRODUCT_OFF_TEXT.'</div>
                                                                    </div>
                                                                </div></div>';
                                        $closeHtml_text = FS_PRODUCT_OFF_TEXT_2;
                                        $offline_no_stock = $off_html;
                                    }else{
                                        if($pro['total_qty']){
                                            $closeHtml_text = FS_PRODUCT_CLEARANCE_TEXT_1;
                                        }else{
                                            $closeHtml_text = FS_PRODUCT_CLEARANCE_TEXT;
                                        }
                                        if($pro['qty']){
                                            $is_show_qty = true;
                                        }
                                    }
                                    if ($son_order_ids){
                                        foreach ($son_order_ids as $son_order_id){
                                            $final_price_id = implode($son_order_id);
                                            $final_price=$db->getAll("select final_price from orders_products where orders_id={$final_price_id} and products_id={$pro['id']}  ");
                                            if ($final_price[0]!=null) {
                                                $product_price = implode($final_price[0]);
                                            }
                                        }
                                    }else if($_POST['orders_id'] != ''){
                                        $final_price=$db->getAll("select final_price from orders_products where orders_id={$_POST['orders_id']} and products_id={$pro['id']}");
                                        $product_price = implode($final_price[0]);
                                    }else{
                                        $final_price=$db->getAll("select final_price from orders_products where orders_products_id={$_POST['orders_products_id']} and products_id={$pro['id']}");
                                        $product_price = implode($final_price[0]);
                                    };
                                    $currency = $_SESSION['currency'];
                                    $currency_value = $currencies->currencies[$_SESSION['currency']]['value'];
                                    $product_price =$currencies->total_format($product_price, true, $currency, $currency_value);
                                    $link = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id='.intval($pro['id']),'NONSSL');
                                    // 产品图片
                                    $image = get_resources_img($pro['id'],80,80);
                                    $closeHtml .='<div class="new-clearance-list">';

                                    if(($closeNum && $kk==0) || ($cleProNum && $kk==$closeNum) || ($NoCleProNum && $kk==($closeNum+$cleProNum))){ //相同类型产品只展示一个提示语
                                        $closeHtml .='<div class="clearance-order_return-container">
                                                            <div class="order_return quote_order_return" id="">
                                                                <i class="iconfont icon">&#xf228;</i>
                                                                '.$closeHtml_text.'
                                                            </div>	
                                                        </div>';
                                    }

                                    $closeHtml .='<div class="addCrat_item_listTa">
                                                    <div>
                                                        <div class="addCrat_item_list_top">
                                                            <div class="addCrat_left" id="video_img">
                                                                '.$offline_no_stock.'
                                                                <span class="invalid_img">'.$image.'</span>
                                                            </div>
                                                            <div class="addCrat_right">
                                                                <h1 class="addCrat_item_list_tit" id="video_array_title"><span>'.$pro['name'].'</span></h1>';
                                    if(!empty($pro['is_clearance'])){
                                        $closeHtml .='<p class="Qty_num02">#'.$pro['id'].'</p>';
                                    }
                                    $closeHtml .=''.($is_show_qty ? '<p class="Qty_num02">'.$pro['qty'].' x '.$product_price.'/'. MANAGE_ORDER_EA .'</p>' : '').'';

                                    if(empty($pro['is_clearance'])){ //清仓产品不展示该版块
                                        $closeHtml .='<p class="clearance-a">
                                                    <a href="'.$link.'">'. FS_SHOP_CART_SIMILAR.'</a>
                                                    <i class="iconfont icon">&#xf089;</i>
                                                </p>';
                                    }

                                    $closeHtml .='        </div>
                                                        </div>
                                                    </div>
                                                </div>	
                                            </div>';
                                }
                                $unque_pid[] = $pro['id'];
                            }
                        }
                        if($customNum){
                            //2019.2.26 pico 下架商品弹窗价格展示
                            $son_order_ids = $db->getAll("select orders_id from orders where main_order_id={$_POST['orders_id']}");
                            foreach($customPro as $cus_key => $pro){
                                $lihtml='';
                                foreach ($pro['attribute'] as $k=>$attribute) {
                                    $special = false;
                                    if(strpos($k, 'upload_prefix_') !== false || strpos($k, 'text_prefix_') !== false){
                                        $special = true;
                                    }
                                    if (is_array($attribute) && !$special){
                                        //不准确
//                                        $attribute=implode($attribute);
                                        foreach ($attribute as $key=>$attr){
                                            $attr_options = $db->Execute("select products_options_name from products_options where products_options_id={$k} and language_id={$_SESSION['languages_id']}")->fields['products_options_name'];
                                            $attr_values = $db->Execute("select products_options_values_name from products_options_values where products_options_values_id={$attr} and language_id={$_SESSION['languages_id']}")->fields['products_options_values_name'];
                                            $lihtml .= '<li>'.$attr_options.' - '.$attr_values.'</li>';
                                        }
                                    }else if ($k == 'length'){
                                        $attr_options = FS_LENGTH_NAME;
                                        $attr_values = $db->Execute("select length from products_length where id={$attribute}")->fields['length'];
                                        $attr_values = zen_show_product_length($attr_values,(int)$pro['id']);
                                    }else {
                                        //客户自己填写的内容 value_id 都是0  key格式是文字 [text_prefix_option_id]
                                        //   附件 [upload_prefix_option_id]
                                        if (strpos($k, 'upload_prefix_') !== false) {
                                            $k = substr($k, strlen('upload_prefix_'));
                                            $attr_values = $attribute['products_options_value_text'];
                                        }elseif (strpos($k, TEXT_PREFIX) !== false){
                                            $k = substr($k, strlen(TEXT_PREFIX));
                                            $attr_values = $attribute;
                                        }else{
                                            $attr_values = $db->Execute("select products_options_values_name from products_options_values where products_options_values_id={$attribute} and language_id={$_SESSION['languages_id']}")->fields['products_options_values_name'];
                                        }
                                        $attr_options = $db->Execute("select products_options_name from products_options where products_options_id={$k} and language_id={$_SESSION['languages_id']}")->fields['products_options_name'];
                                    }
                                    $lihtml .= '<li>'.$attr_options.' - '.$attr_values.'</li>';
                                }
                                if ($son_order_ids){
                                    foreach ($son_order_ids as $son_order_id){
                                        $final_price_id = implode($son_order_id);
                                        $final_price=$db->getAll("select final_price from orders_products where orders_id={$final_price_id} and products_id={$pro['id']} ");
                                        if ($final_price[0]!=null) {
                                            $product_price = implode($final_price[0]);
                                        }
                                    }
                                }else if($_POST['orders_id'] != ''){
                                    $final_price=$db->getAll("select final_price from orders_products where orders_id={$_POST['orders_id']} and products_id={$pro['id']}");
                                    $product_price = implode($final_price[0]);
                                }else{
                                    $final_price=$db->getAll("select final_price from orders_products where orders_products_id={$_POST['orders_products_id']} and products_id={$pro['id']}");
                                    $product_price = implode($final_price[0]);
                                };
                                $currency = $_SESSION['currency'];
                                $currency_value = $currencies->currencies[$_SESSION['currency']]['value'];
                                $product_price =$currencies->total_format($product_price, true, $currency, $currency_value);
                                $link = zen_href_link(FILENAME_PRODUCT_INFO, '&products_id='.intval($pro['id']),'NONSSL');
                                // 产品图片
                                $image = get_resources_img($pro['id'],80,80);


                            $customHtml .='<div class="new-clearance-list">';

                            if($customNum && $cus_key==0){  //相同类型产品只展示一个提示语
                                $customHtml .='<div class="clearance-order_return-container">
                                                    <div class="order_return quote_order_return" id="">
                                                        <i class="iconfont icon">&#xf228;</i>
                                                        '.FS_PRODUCT_OFF_TEXT_4.'
                                                    </div>	
                                                </div>';
                            }

                            $customHtml .='<div class="addCrat_item_listTa">
                                                    <div>
                                                        <div class="addCrat_item_list_top">
                                                            <div class="addCrat_left" id="video_img">
                                                                <span>'.$image.'</span>
                                                            </div>
                                                            <div class="addCrat_right">
                                                                <h1 class="addCrat_item_list_tit" id="video_array_title"><span data-is-common-title="">'.$pro['name'].'</span></h1>
                                                                <ul class="attribute">'.$lihtml.'</ul>
                                                                <p class="Qty_num02">#'.$pro['id'].'</p>
                                                                <p class="clearance-a">
                                                                    <a href="'.$link.'">'.FS_PRODUCT_OFF_TEXT_3.'</a>
                                                                    <i class="iconfont icon">&#xf089;</i>
													            </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>';
                            }
                        }
                        //var_dump($closeHtml);
                        $html .= $customHtml.$closeHtml;
                        if($type==2){
                            $html .= '<div class="alone_text_right">
							<a class="new_alone_button alone_his new_alone_border_gray alone_a_min_width" href="javascript: ;" onclick="hide_reorder_window();">'.FS_COMMON_CANCEL.'</a></div>';
                        }else{
                            $html .= '<div class="alone_text_right">
							<a class="new_alone_button alone_his new_alone_border_gray alone_a_min_width" href="javascript: ;" onclick="hide_reorder_window();">'.FS_COMMON_CANCEL.'</a>
							<button class="new_alone_button alone_none_border alone_his alone_a_min_width" onclick="restore_order_products('.$orders_id.',2)">'.FS_COMMON_REORDER_SKIP.'</button>
						</div>';
                        }
						$html .= '<input type="hidden" id="reorder_orders_id" value="'.$orders_id.'">';
                    }
                }
                $data = array('type'=>$type,'html'=>$html,'topCartHtml'=>$topCartHtml);
                echo json_encode($data);
            }else{
                echo 'err';
            }
            exit;
            break;
		}
	}
}
