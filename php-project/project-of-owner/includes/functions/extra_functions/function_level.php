<?php
/***
 * 黑名单限制
 * update by aron 2019 2.21
 * @param string $email_address
 * @return bool
 */
function get_user_blacklist($email_address = "")
{
    global $db;
    if ($email_address) {
        $blacklist = $db->getAll("select count(*) as total from customers where customers_authorization = 4 and customers_email_address='" . $email_address . "'");
        $black_email_list = "";
        if (strpos($email_address, "@") !== false) {
            $translate_email = explode("@", $email_address);
            $suffix = "@" . $translate_email[1];
            $black_email_list = fs_get_data_from_db_fields("id", "black_mail_suffix", "mail_suffix = '{$email_address}' or mail_suffix = '{$suffix}'");
        }
        if ($blacklist[0]['total'] > 0 || $black_email_list) {
            return true;
        } else {
            return false;
        }
    }
    return false;
}

function get_is_customer_email($email_address){
    global $db;
    $blacklist= $db->getAll("select count(*) from customers where customers_email_address='".$email_address."'");
    if($blacklist[0]['count(*)']>0){
        return true;
    }else{
        return false;
    }
}

function get_customers_products_level_price($product_price,$level,$pid=""){
		
		global $db,$currencies;
		$discount_rate = 1;
		$decimal = $currencies->currencies[$_SESSION['currency']]['decimal_places'];
        $is_discount = true;
		if(isset($level)  && $level){

			//$re = $db->Execute("select * from  customers_level where id = '$level' limit 1");
            if($pid){
                $is_discount = is_discount($pid);
            }
			if(isset($_SESSION['customer_id']) && $is_discount){

				$re = $db->Execute("select discount_rate from  customers where customers_id = '".$_SESSION['customer_id']."' limit 1");
			

				$discount_rate = $re->fields['discount_rate'];
			}


		}
		return get_customers_products_level_final_price(round($product_price*$discount_rate,$decimal));

}

function get_customers_products_level_final_price($final_price){
	//if($cpa[0] == 9){
		//if($final_price>=40){
			//$final_price = round($final_price,0);
		//}else{
			//$final_price = round($final_price,2);
		//}
	//}else{
		/*
		if($final_price>=10 && $final_price<100){
			$final_price = round($final_price,1);
		}elseif($final_price>=100){
			$final_price = round($final_price,0);
		}*/
		return $final_price;
	//}
}

function get_products_all_currency_final_price($price){
        $products_price = round($price,2);
		if($products_price<1){
			$products_price = round($products_price,2);
		}elseif($products_price>=1 && $products_price<10){
			$products_price = round($products_price,1);
	    }elseif($products_price>=10 && $products_price<100){
			$products_price = round($products_price,0);
	    }elseif($products_price>=100 && $products_price<1000){
			$products_price = round($products_price/10,0)*10;
	    }elseif($products_price>=1000 && $products_price<10000){
			$products_price = round($products_price/100,0)*100;
		}elseif($products_price>=10000){
			$products_price = round($products_price/1000,0)*1000;
		}
	return zen_add_tax($products_price,0);
}


function get_products_specail_currency_final_price($price){
        $products_price = round($price,2);
		if($products_price<1){
			$products_price = round($products_price,2);
		}elseif($products_price>=1 && $products_price<10){
			$products_price = round($products_price,1);
	    }elseif($products_price>=10){
			$products_price = round($products_price,0);
	    }
	return zen_add_tax($products_price,0);
}



function get_customers_member_level(){
	global $db;
	$level = $db->Execute("select member_level from customers where customers_id = '".$_SESSION['customer_id']."'");
	if($level->fields['member_level']){
		$_SESSION['member_level'] = $level->fields['member_level'];
	}else{
		$_SESSION['member_level'] = 1;
	}
}

function get_customers_shipping_discount_status(){
		
		global $db;

		if(isset($_SESSION['customer_id'])){

			$re = $db->Execute("select shipping_discount_rate from  customers where customers_id = '".$_SESSION['customer_id']."' limit 1");

			if($re->fields['shipping_discount_rate'] == '2.00'){

				return  true;
			}
		}

		return false;

}

function fs_html_table_of_productid($id){
  $html ='';
 if($id == 33185){
  $html='<div class="open-close-section">
      <div class="open-close filter-item  open-close-no">
        <div class="opener-holder opener ">Options for Complete Outdoor 1x4 PLC Splitter</div>

        <div class="slide">
          <div class="sub-open-close sub-active">
            <div class="opener-holder">Option 1</div>
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0" width="100%">
                <tr>
                  <th>Equipped Qty (PCS)</th>
                  <th>ID#</th>
                  <th >Description</th>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/33185.html" target="_blank">33185</a></td>
                  <td >1×4 Fiber PLC Splitter in Mini plug-in Type</td>
                  
                </tr>
				 <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29661.html" target="_blank">29661</a></td>
                  <td >1x8 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                  
                </tr>
				<tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td >4-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                  
                </tr>
				<tr>
                  <td>4</td>
                  <td><a href="http://www.fs.com/products/14240.html" target="_blank">14240</a></td>
                  <td >Simplex 9/125 Single-mode LC/SC/ST/FC Pigtail</td>
                  
                </tr>
              </table>
            </div>
          </div>
        </div>
       
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder">Option 2</div>
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0" width="100%">
            <tr>
              <th>Equipped Qty (PCS)</th>
              <th>ID#</th>
              
              <th >Description</th>
              </tr>
                <tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/31385.html" target="_blank">33185</a></td>
                  <td>1×4 Fiber PLC Splitter in Mini plug-in Type</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29665.html" target="_blank">29665</a></td>
                  <td>1×16 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/14240.html" target="_blank">14240</a></td>
                  <td>Simplex 9/125 Single-mode LC/SC/ST/FC Pigtail</td>
                </tr>
        </table>
            </div>
          </div>
        </div>
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder">Option 3</div>
            <div class="sub-slide">
              <table width="100%" cellpadding="0" cellspacing="0" >
                <tr>
                  <th>Equipped Qty (PCS)</th>
                  <th>ID#</th>
                  <th>Description</th>
                </tr>
                <tr>
                  <td>4</td>
                  <td><a href="http://www.fs.com/products/33185.html" target="_blank">33185</a></td>
                  <td>1×4 Fiber PLC Splitter in Mini plug-in Type</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29664.html" target="_blank">29664</a></td>
                  <td>1x32 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                </tr>
				 <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
				<tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>4-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
            </table>
            </div>
          </div>
        </div>
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder">Option 4</div>
            <div class="sub-slide">
              <table width="100%" cellpadding="0" cellspacing="0" >
                <tr>
                  <th>Equipped Qty (PCS)</th>
                  <th>ID#</th>
                  <th>Description</th>
                </tr>
                <tr>
                  <td>8</td>
                  <td><a href="http://www.fs.com/products/33185.html" target="_blank">33185</a></td>
                  <td>1×4 Fiber PLC Splitter in Mini plug-in Type</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29678.html" target="_blank">29678</a></td>
                  <td>1×64 Fiber Optical Splitter SPCC Terminal Box As Distribution Box</td>
                </tr>
				 <tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
				<tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
            </table>
            </div>
          </div>
	    </div>
    </div></div>';
 }else if($id == 33246){
  $html='<div class="open-close-section">
      <div class="open-close filter-item  open-close-no">
        <div class="opener-holder opener ">Options for Complete Outdoor 1x2 PLC Splitter</div>

        <div class="slide">
          <div class="sub-open-close sub-active">
            <div class="opener-holder">Option 1</div>
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0" width="100%">
                <tr>
                  <th>Equipped Qty (PCS)</th>
                  <th>ID#</th>
                  <th >Description</th>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/33246.html" target="_blank">33246</a></td>
                  <td >1×2 Fiber PLC Splitter in Mini plug-in Type</td>
                  
                </tr>
				 <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29661.html" target="_blank">29661</a></td>
                  <td >1x8 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                  
                </tr>
				<tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/14240.html" target="_blank">14240</a></td>
                  <td >Simplex 9/125 Single-mode LC/SC/ST/FC Pigtail</td>
                  
                </tr>
				<tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/14240.html" target="_blank">14240</a></td>
                  <td >Simplex 9/125 Single-mode LC/SC/ST/FC Pigtail</td>
                  
                </tr>
              </table>
            </div>
          </div>
        </div>
       
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder">Option 2</div>
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0" width="100%">
            <tr>
              <th>Equipped Qty (PCS)</th>
              <th>ID#</th>
              
              <th >Description</th>
              </tr>
                <tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/33246.html" target="_blank">33246</a></td>
                  <td>1×2 Fiber PLC Splitter in Mini plug-in Type</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29665.html" target="_blank">29665</a></td>
                  <td>1×16 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>4-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/14240.html" target="_blank">14240</a></td>
                  <td>Simplex 9/125 Single-mode LC/SC/ST/FC Pigtail</td>
                </tr>
        </table>
            </div>
          </div>
        </div>
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder">Option 3</div>
            <div class="sub-slide">
              <table width="100%" cellpadding="0" cellspacing="0" >
                <tr>
                  <th>Equipped Qty (PCS)</th>
                  <th>ID#</th>
                  <th>Description</th>
                </tr>
                <tr>
                  <td>4</td>
                  <td><a href="http://www.fs.com/products/33246.html" target="_blank">33246</a></td>
                  <td>1×2 Fiber PLC Splitter in Mini plug-in Type</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29664.html" target="_blank">29664</a></td>
                  <td>1x32 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                </tr>
				 <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
				<tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>4-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
            </table>
            </div>
          </div>
        </div>
		
		
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder">Option 4</div>
            <div class="sub-slide">
              <table width="100%" cellpadding="0" cellspacing="0" >
                <tr>
                  <th>Equipped Qty (PCS)</th>
                  <th>ID#</th>
                  <th>Description</th>
                </tr>
                <tr>
                  <td>8</td>
                  <td><a href="http://www.fs.com/products/33246.html" target="_blank">33246</a></td>
                  <td>1×2 Fiber PLC Splitter in Mini plug-in Type</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29678.html" target="_blank">29678</a></td>
                  <td>1×64 Fiber Optical Splitter SPCC Terminal Box As Distribution Box</td>
                </tr>
				 <tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
				<tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
            </table>
            </div>
          </div>
	    </div>
    </div></div>';
 }else if($id == 33247){
 $html='<div class="open-close-section">
      <div class="open-close filter-item  open-close-no">
        <div class="opener-holder opener ">Options for Complete Outdoor 1x8 PLC Splitter</div>

        <div class="slide">
          <div class="sub-open-close sub-active">
            <div class="opener-holder">Option 1</div>
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0" width="100%">
                <tr>
                  <th>Equipped Qty (PCS)</th>
                  <th>ID#</th>
                  <th >Description</th>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/33247.html" target="_blank">33247</a></td>
                  <td >1×8 Fiber PLC Splitter in Mini plug-in Type</td>
                  
                </tr>
				 <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29661.html" target="_blank">29661</a></td>
                  <td >1x8 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                  
                </tr>
				<tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td >8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                  
                </tr>
				<tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/14240.html" target="_blank">14240</a></td>
                  <td >Simplex 9/125 Single-mode LC/SC/ST/FC Pigtail</td>
                  
                </tr>
              </table>
            </div>
          </div>
        </div>
       
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder">Option 2</div>
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0" width="100%">
            <tr>
              <th>Equipped Qty (PCS)</th>
              <th>ID#</th>
              
              <th >Description</th>
              </tr>
                <tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/33247.html" target="_blank">33247</a></td>
                  <td>1×8 Fiber PLC Splitter in Mini plug-in Type</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29665.html" target="_blank">29665</a></td>
                  <td>1×16 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/14240.html" target="_blank">14240</a></td>
                  <td>Simplex 9/125 Single-mode LC/SC/ST/FC Pigtail</td>
                </tr>
        </table>
            </div>
          </div>
        </div>
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder">Option 3</div>
            <div class="sub-slide">
              <table width="100%" cellpadding="0" cellspacing="0" >
                <tr>
                  <th>Equipped Qty (PCS)</th>
                  <th>ID#</th>
                  <th>Description</th>
                </tr>
                <tr>
                  <td>4</td>
                  <td><a href="http://www.fs.com/products/33247.html" target="_blank">33247</a></td>
                  <td>1×8 Fiber PLC Splitter in Mini plug-in Type</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29664.html" target="_blank">29664</a></td>
                  <td>1x32 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                </tr>
				 <tr>
                  <td>4</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
				<tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>4-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
            </table>
            </div>
          </div>
        </div>
		
		
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder">Option 4</div>
            <div class="sub-slide">
              <table width="100%" cellpadding="0" cellspacing="0" >
                <tr>
                  <th>Equipped Qty (PCS)</th>
                  <th>ID#</th>
                  <th>Description</th>
                </tr>
                <tr>
                  <td>8</td>
                  <td><a href="http://www.fs.com/products/33247.html" target="_blank">33247</a></td>
                  <td>1×8 Fiber PLC Splitter in Mini plug-in Type</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29678.html" target="_blank">29678</a></td>
                  <td>1×64 Fiber Optical Splitter SPCC Terminal Box As Distribution Box</td>
                </tr>
				 <tr>
                  <td>8</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
				<tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
            </table>
            </div>
          </div>
	    </div>
    </div></div>';
 }else if($id== 33248){
 $html='<div class="open-close-section">
      <div class="open-close filter-item  open-close-no">
        <div class="opener-holder opener ">Options for Complete Outdoor 1x16 PLC Splitter</div>

        <div class="slide">
          <div class="sub-open-close sub-active">
            <div class="opener-holder">Option 1</div>
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0" width="100%">
                <tr>
                  <th>Equipped Qty (PCS)</th>
                  <th>ID#</th>
                  <th >Description</th>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/33248.html" target="_blank">33248</a></td>
                  <td >1×16 Fiber PLC Splitter in Mini plug-in Type</td>
                  
                </tr>
				 <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29665.html" target="_blank">29665</a></td>
                  <td >1x16 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                  
                </tr>
				<tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td >8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                  
                </tr>
				<tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/14240.html" target="_blank">14240</a></td>
                  <td >Simplex 9/125 Single-mode LC/SC/ST/FC Pigtail</td>
                  
                </tr>
              </table>
            </div>
          </div>
        </div>
       
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder">Option 2</div>
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0" width="100%">
            <tr>
              <th>Equipped Qty (PCS)</th>
              <th>ID#</th>
              
              <th >Description</th>
              </tr>
                <tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/33248.html" target="_blank">33248</a></td>
                  <td>1×16 Fiber PLC Splitter in Mini plug-in Type</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29664.html" target="_blank">29664</a></td>
                  <td>1×32 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                </tr>
                <tr>
                  <td>4</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/14240.html" target="_blank">14240</a></td>
                  <td>Simplex 9/125 Single-mode LC/SC/ST/FC Pigtail</td>
                </tr>
        </table>
            </div>
          </div>
        </div>
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder">Option 3</div>
            <div class="sub-slide">
              <table width="100%" cellpadding="0" cellspacing="0" >
                <tr>
                  <th>Equipped Qty (PCS)</th>
                  <th>ID#</th>
                  <th>Description</th>
                </tr>
                <tr>
                  <td>4</td>
                  <td><a href="http://www.fs.com/products/33248.html" target="_blank">33248</a></td>
                  <td>1×16 Fiber PLC Splitter in Mini plug-in Type</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29678.html" target="_blank">29678</a></td>
                  <td>1x64 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                </tr>
				 <tr>
                  <td>8</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
				<tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>4-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
            </table>
            </div>
          </div>
        </div>
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder"></div>
          </div>
        </div>
    </div></div> ';
 }else if($id == 33249){
 $html='<div class="open-close-section">
      <div class="open-close filter-item  open-close-no">
        <div class="opener-holder opener ">Options for Complete Outdoor 1x32 PLC Splitter</div>

        <div class="slide">
          <div class="sub-open-close sub-active">
            <div class="opener-holder">Option 1</div>
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0" width="100%">
                <tr>
                  <th>Equipped Qty (PCS)</th>
                  <th>ID#</th>
                  <th >Description</th>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/33249.html" target="_blank">33249</a></td>
                  <td >1×32 Fiber PLC Splitter in Mini plug-in Type</td>
                  
                </tr>
				 <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29664.html" target="_blank">29664</a></td>
                  <td >1x32 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                  
                </tr>
				<tr>
                  <td>4</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td >8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                  
                </tr>
				<tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/14240.html" target="_blank">14240</a></td>
                  <td >Simplex 9/125 Single-mode LC/SC/ST/FC Pigtail</td>
                  
                </tr>
              </table>
            </div>
          </div>
        </div>
       
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder">Option 2</div>
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0" width="100%">
            <tr>
              <th>Equipped Qty (PCS)</th>
              <th>ID#</th>
              
              <th >Description</th>
              </tr>
                <tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/33249.html" target="_blank">33249</a></td>
                  <td>1×32 Fiber PLC Splitter in Mini plug-in Type</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29678.html" target="_blank">29678</a></td>
                  <td>1×64 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                </tr>
                <tr>
                  <td>8</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/14240.html" target="_blank">14240</a></td>
                  <td>Simplex 9/125 Single-mode LC/SC/ST/FC Pigtail</td>
                </tr>
        </table>
            </div>
          </div>
        </div>
        <div class="slide" >
          <div class="sub-open-close"></div>
        </div>
		
		
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder"></div>
          </div>
        </div>
    </div></div>';
 }else if($id == 33250){
 $html='<div class="open-close-section">
      <div class="open-close filter-item  open-close-no">
        <div class="opener-holder opener ">Options for Complete Outdoor 1x64 PLC Splitter</div>

        <div class="slide">
          <div class="sub-open-close sub-active">
            <div class="opener-holder">Option 1</div>
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0" width="100%">
                <tr>
                  <th>Equipped Qty (PCS)</th>
                  <th>ID#</th>
                  <th >Description</th>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/33250.html" target="_blank">33250</a></td>
                  <td >1×64 Fiber PLC Splitter in Mini plug-in Type</td>
                  
                </tr>
				 <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29678.html" target="_blank">29678</a></td>
                  <td >1x64 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                  
                </tr>
				<tr>
                  <td>8</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td >8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                  
                </tr>
				<tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/14240.html" target="_blank">14240</a></td>
                  <td >Simplex 9/125 Single-mode LC/SC/ST/FC Pigtail</td>
                  
                </tr>
              </table>
            </div>
          </div>
        </div>
       
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder"></div>
            </div>
        </div>
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder"></div>
          </div>
        </div>
    </div></div>';
 }else if($id == 33252){
 $html='<div class="open-close-section">
      <div class="open-close filter-item  open-close-no">
        <div class="opener-holder opener ">Options for Complete Outdoor 2x2 PLC Splitter</div>

        <div class="slide">
          <div class="sub-open-close sub-active">
            <div class="opener-holder">Option 1</div>
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0" width="100%">
                <tr>
                  <th>Equipped Qty (PCS)</th>
                  <th>ID#</th>
                  <th >Description</th>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/33252.html" target="_blank">33252</a></td>
                  <td >2×2 Fiber PLC Splitter in Mini plug-in Type</td>
                  
                </tr>
				 <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29661.html" target="_blank">29661</a></td>
                  <td >1x8 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                  
                </tr>
				<tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/14240.html" target="_blank">14240</a></td>
                  <td >Simplex 9/125 Single-mode LC/SC/ST/FC Pigtail</td>
                  
                </tr>
				<tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/14240.html" target="_blank">14240</a></td>
                  <td >Simplex 9/125 Single-mode LC/SC/ST/FC Pigtail</td>
                  
                </tr>
              </table>
            </div>
          </div>
        </div>
       
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder">Option 2</div>
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0" width="100%">
            <tr>
              <th>Equipped Qty (PCS)</th>
              <th>ID#</th>
              
              <th >Description</th>
              </tr>
                <tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/33252.html" target="_blank">33252</a></td>
                  <td>2×2 Fiber PLC Splitter in Mini plug-in Type</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29665.html" target="_blank">29665</a></td>
                  <td>1×16 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>4-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>4-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
        </table>
            </div>
          </div>
        </div>
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder">Option 3</div>
            <div class="sub-slide">
              <table width="100%" cellpadding="0" cellspacing="0" >
                <tr>
                  <th>Equipped Qty (PCS)</th>
                  <th>ID#</th>
                  <th>Description</th>
                </tr>
                <tr>
                  <td>4</td>
                  <td><a href="http://www.fs.com/products/33252.html" target="_blank">33252</a></td>
                  <td>2×2 Fiber PLC Splitter in Mini plug-in Type</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/39664.html" target="_blank">29664</a></td>
                  <td>1x32 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                </tr>
				 <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
				<tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
            </table>
            </div>
          </div>
        </div>
		
		
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder">Option 4</div>
            <div class="sub-slide">
              <table width="100%" cellpadding="0" cellspacing="0" >
                <tr>
                  <th>Equipped Qty (PCS)</th>
                  <th>ID#</th>
                  <th>Description</th>
                </tr>
                <tr>
                  <td>8</td>
                  <td><a href="http://www.fs.com/products/33252.html" target="_blank">33252</a></td>
                  <td>2×2 Fiber PLC Splitter in Mini plug-in Type</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29678.html" target="_blank">29678</a></td>
                  <td>1×64 Fiber Optical Splitter SPCC Terminal Box As Distribution Box</td>
                </tr>
				 <tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
				<tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
            </table>
            </div>
          </div>
	    </div>
    </div></div>';
 }else if($id== 33253){
 $html='<div class="open-close-section">
      <div class="open-close filter-item  open-close-no">
        <div class="opener-holder opener ">Options for Complete Outdoor 2x4 PLC Splitter</div>

        <div class="slide">
          <div class="sub-open-close sub-active">
            <div class="opener-holder">Option 1</div>
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0" width="100%">
                <tr>
                  <th>Equipped Qty (PCS)</th>
                  <th>ID#</th>
                  <th >Description</th>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/33253.html" target="_blank">33253</a></td>
                  <td >2×4 Fiber PLC Splitter in Mini plug-in Type</td>
                  
                </tr>
				 <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29661.html" target="_blank">29661</a></td>
                  <td >1x8 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                  
                </tr>
				<tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td >4-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                  
                </tr>
				<tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/14240.html" target="_blank">14240</a></td>
                  <td >Simplex 9/125 Single-mode LC/SC/ST/FC Pigtail</td>
                  
                </tr>
              </table>
            </div>
          </div>
        </div>
       
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder">Option 2</div>
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0" width="100%">
            <tr>
              <th>Equipped Qty (PCS)</th>
              <th>ID#</th>
              
              <th >Description</th>
              </tr>
                <tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/33253.html" target="_blank">33253</a></td>
                  <td>2×4 Fiber PLC Splitter in Mini plug-in Type</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29665.html" target="_blank">29665</a></td>
                  <td>1×16 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>4-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
        </table>
            </div>
          </div>
        </div>
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder">Option 3</div>
            <div class="sub-slide">
              <table width="100%" cellpadding="0" cellspacing="0" >
                <tr>
                  <th>Equipped Qty (PCS)</th>
                  <th>ID#</th>
                  <th>Description</th>
                </tr>
                <tr>
                  <td>4</td>
                  <td><a href="http://www.fs.com/products/33253.html" target="_blank">33253</a></td>
                  <td>2×4 Fiber PLC Splitter in Mini plug-in Type</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29664.html" target="_blank">29664</a></td>
                  <td>1x32 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                </tr>
				 <tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
				<tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
            </table>
            </div>
          </div>
        </div>
		
		
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder">Option 4</div>
            <div class="sub-slide">
              <table width="100%" cellpadding="0" cellspacing="0" >
                <tr>
                  <th>Equipped Qty (PCS)</th>
                  <th>ID#</th>
                  <th>Description</th>
                </tr>
                <tr>
                  <td>8</td>
                  <td><a href="http://www.fs.com/products/33253.html" target="_blank">33253</a></td>
                  <td>2×4 Fiber PLC Splitter in Mini plug-in Type</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29678.html" target="_blank">29678</a></td>
                  <td>1×64 Fiber Optical Splitter SPCC Terminal Box As Distribution Box</td>
                </tr>
				 <tr>
                  <td>4</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
				<tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
            </table>
            </div>
          </div>
	    </div>
    </div></div>';
 }else if($id ==33255){
 $html='<div class="open-close-section">
      <div class="open-close filter-item  open-close-no">
        <div class="opener-holder opener ">Options for Complete Outdoor 2x8 PLC Splitter</div>

        <div class="slide">
          <div class="sub-open-close sub-active">
            <div class="opener-holder">Option 1</div>
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0" width="100%">
                <tr>
                  <th>Equipped Qty (PCS)</th>
                  <th>ID#</th>
                  <th >Description</th>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/33255.html" target="_blank">33255</a></td>
                  <td >2×8 Fiber PLC Splitter in Mini plug-in Type</td>
                  
                </tr>
				 <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29661.html" target="_blank">29661</a></td>
                  <td >1x8 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                  
                </tr>
				<tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td >8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                  
                </tr>
				<tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/14240.html" target="_blank">14240</a></td>
                  <td >Simplex 9/125 Single-mode LC/SC/ST/FC Pigtail</td>
                  
                </tr>
              </table>
            </div>
          </div>
        </div>
       
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder">Option 2</div>
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0" width="100%">
            <tr>
              <th>Equipped Qty (PCS)</th>
              <th>ID#</th>
              
              <th >Description</th>
              </tr>
                <tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/33255.html" target="_blank">33255</a></td>
                  <td>2×8 Fiber PLC Splitter in Mini plug-in Type</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29665.html" target="_blank">29665</a></td>
                  <td>1×16 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>4-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
        </table>
            </div>
          </div>
        </div>
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder">Option 3</div>
            <div class="sub-slide">
              <table width="100%" cellpadding="0" cellspacing="0" >
                <tr>
                  <th>Equipped Qty (PCS)</th>
                  <th>ID#</th>
                  <th>Description</th>
                </tr>
                <tr>
                  <td>4</td>
                  <td><a href="http://www.fs.com/products/33255.html" target="_blank">33255</a></td>
                  <td>2×8 Fiber PLC Splitter in Mini plug-in Type</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29664.html" target="_blank">29664</a></td>
                  <td>1x32 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                </tr>
				 <tr>
                  <td>4</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
				<tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
            </table>
            </div>
          </div>
        </div>
		
		
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder">Option 4</div>
            <div class="sub-slide">
              <table width="100%" cellpadding="0" cellspacing="0" >
                <tr>
                  <th>Equipped Qty (PCS)</th>
                  <th>ID#</th>
                  <th>Description</th>
                </tr>
                <tr>
                  <td>8</td>
                  <td><a href="http://www.fs.com/products/33255.html" target="_blank">33255</a></td>
                  <td>2×8 Fiber PLC Splitter in Mini plug-in Type</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29678.html" target="_blank">29678</a></td>
                  <td>1×64 Fiber Optical Splitter SPCC Terminal Box As Distribution Box</td>
                </tr>
				 <tr>
                  <td>8</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
				<tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
            </table>
            </div>
          </div>
	    </div>
    </div></div>';
 }else if($id == 33256){
 $html ='<div class="open-close-section">
      <div class="open-close filter-item  open-close-no">
        <div class="opener-holder opener ">Options for Complete Outdoor 2x16 PLC Splitter</div>

        <div class="slide">
          <div class="sub-open-close sub-active">
            <div class="opener-holder">Option 1</div>
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0" width="100%">
                <tr>
                  <th>Equipped Qty (PCS)</th>
                  <th>ID#</th>
                  <th >Description</th>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/33256.html" target="_blank">33256</a></td>
                  <td >2×16 Fiber PLC Splitter in Mini plug-in Type</td>
                  
                </tr>
				 <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29665.html" target="_blank">29665</a></td>
                  <td >1x16 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                  
                </tr>
				<tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td >8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                  
                </tr>
				<tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/14240.html" target="_blank">14240</a></td>
                  <td >Simplex 9/125 Single-mode LC/SC/ST/FC Pigtail</td>
                  
                </tr>
              </table>
            </div>
          </div>
        </div>
       
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder">Option 2</div>
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0" width="100%">
            <tr>
              <th>Equipped Qty (PCS)</th>
              <th>ID#</th>
              
              <th >Description</th>
              </tr>
                <tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/33256.html" target="_blank">33256</a></td>
                  <td>2×16 Fiber PLC Splitter in Mini plug-in Type</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29664.html" target="_blank">29664</a></td>
                  <td>1×32 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                </tr>
                <tr>
                  <td>4</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>4-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
        </table>
            </div>
          </div>
        </div>
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder">Option 3</div>
            <div class="sub-slide">
              <table width="100%" cellpadding="0" cellspacing="0" >
                <tr>
                  <th>Equipped Qty (PCS)</th>
                  <th>ID#</th>
                  <th>Description</th>
                </tr>
                <tr>
                  <td>4</td>
                  <td><a href="http://www.fs.com/products/33256.html" target="_blank">33256</a></td>
                  <td>2×16 Fiber PLC Splitter in Mini plug-in Type</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29678.html" target="_blank">29678</a></td>
                  <td>1x64 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                </tr>
				 <tr>
                  <td>8</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
				<tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
            </table>
            </div>
          </div>
        </div>
		
		
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder"></div>
          </div>
        </div>
    </div></div> ';
 }else if($id ==33257){
 $html ='<div class="open-close-section">
      <div class="open-close filter-item  open-close-no">
        <div class="opener-holder opener ">Options for Complete Outdoor 2x32 PLC Splitter</div>

        <div class="slide">
          <div class="sub-open-close sub-active">
            <div class="opener-holder">Option 1</div>
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0" width="100%">
                <tr>
                  <th>Equipped Qty (PCS)</th>
                  <th>ID#</th>
                  <th >Description</th>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/33257.html" target="_blank">33257</a></td>
                  <td >2×32 Fiber PLC Splitter in Mini plug-in Type</td>
                  
                </tr>
				 <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29664.html" target="_blank">29664</a></td>
                  <td >1x32 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                  
                </tr>
				<tr>
                  <td>4</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td >8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                  
                </tr>
				<tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/14240.html" target="_blank">14240</a></td>
                  <td >Simplex 9/125 Single-mode LC/SC/ST/FC Pigtail</td>
                  
                </tr>
              </table>
            </div>
          </div>
        </div>
       
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder">Option 2</div>
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0" width="100%">
            <tr>
              <th>Equipped Qty (PCS)</th>
              <th>ID#</th>
              
              <th >Description</th>
              </tr>
                <tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/33257.html" target="_blank">33257</a></td>
                  <td>2×32 Fiber PLC Splitter in Mini plug-in Type</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29678.html" target="_blank">29678</a></td>
                  <td>1×64 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                </tr>
                <tr>
                  <td>8</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>4-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
        </table>
            </div>
          </div>
        </div>
        <div class="slide" >
          <div class="sub-open-close"></div>
        </div>
		
		
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder"></div>
          </div>
        </div>
    </div></div> ';
 }else if($id == 33258){
 $html ='<div class="open-close-section">
      <div class="open-close filter-item  open-close-no">
        <div class="opener-holder opener ">Options for Complete Outdoor 2x64 PLC Splitter</div>

        <div class="slide">
          <div class="sub-open-close sub-active">
            <div class="opener-holder">Option 1</div>
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0" width="100%">
                <tr>
                  <th>Equipped Qty (PCS)</th>
                  <th>ID#</th>
                  <th >Description</th>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/33258.html" target="_blank">33258</a></td>
                  <td >2×64 Fiber PLC Splitter in Mini plug-in Type</td>
                  
                </tr>
				 <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29678.html" target="_blank">29678</a></td>
                  <td >1x64 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                  
                </tr>
				<tr>
                  <td>8</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td >8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                  
                </tr>
				<tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/14240.html" target="_blank">14240</a></td>
                  <td >Simplex 9/125 Single-mode LC/SC/ST/FC Pigtail</td>
                  
                </tr>
              </table>
            </div>
          </div>
        </div>
       
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder"></div>
            </div>
        </div>
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder"></div>
          </div>
        </div>
    </div></div>';
 }else if($id == 48476){
 $html ='<div class="open-close-section">
      <div class="open-close filter-item  open-close-no">
        <div class="opener-holder opener ">Options for Complete Outdoor 1x2 PLC Splitter</div>

        <div class="slide">
          <div class="sub-open-close sub-active">
            <div class="opener-holder">Option 1</div>
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0" width="100%">
                <tr>
                  <th>Equipped Qty (PCS)</th>
                  <th>ID#</th>
                  <th >Description</th>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/33246.html" target="_blank">33246</a></td>
                  <td >1×2 Fiber PLC Splitter in Mini plug-in Type</td>
                  
                </tr>
				 <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29661.html" target="_blank">29661</a></td>
                  <td >1x8 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                  
                </tr>
				<tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/14240.html" target="_blank">14240</a></td>
                  <td >Simplex 9/125 Single-mode LC/SC/ST/FC Pigtail</td>
                  
                </tr>
				<tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/14240.html" target="_blank">14240</a></td>
                  <td >Simplex 9/125 Single-mode LC/SC/ST/FC Pigtail</td>
                  
                </tr>
              </table>
            </div>
          </div>
        </div>
       
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder">Option 2</div>
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0" width="100%">
            <tr>
              <th>Equipped Qty (PCS)</th>
              <th>ID#</th>
              
              <th >Description</th>
              </tr>
                <tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/33246.html" target="_blank">33246</a></td>
                  <td>1×2 Fiber PLC Splitter in Mini plug-in Type</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29665.html" target="_blank">29665</a></td>
                  <td>1×16 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>4-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/14240.html" target="_blank">14240</a></td>
                  <td>Simplex 9/125 Single-mode LC/SC/ST/FC Pigtail</td>
                </tr>
        </table>
            </div>
          </div>
        </div>
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder">Option 3</div>
            <div class="sub-slide">
              <table width="100%" cellpadding="0" cellspacing="0" >
                <tr>
                  <th>Equipped Qty (PCS)</th>
                  <th>ID#</th>
                  <th>Description</th>
                </tr>
                <tr>
                  <td>4</td>
                  <td><a href="http://www.fs.com/products/33246.html" target="_blank">33246</a></td>
                  <td>1×2 Fiber PLC Splitter in Mini plug-in Type</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29664.html" target="_blank">29664</a></td>
                  <td>1x32 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                </tr>
				 <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
				<tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>4-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
            </table>
            </div>
          </div>
        </div>
		
		
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder">Option 4</div>
            <div class="sub-slide">
              <table width="100%" cellpadding="0" cellspacing="0" >
                <tr>
                  <th>Equipped Qty (PCS)</th>
                  <th>ID#</th>
                  <th>Description</th>
                </tr>
                <tr>
                  <td>8</td>
                  <td><a href="http://www.fs.com/products/33246.html" target="_blank">33246</a></td>
                  <td>1×2 Fiber PLC Splitter in Mini plug-in Type</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29678.html" target="_blank">29678</a></td>
                  <td>1×64 Fiber Optical Splitter SPCC Terminal Box As Distribution Box</td>
                </tr>
				 <tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
				<tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
            </table>
            </div>
          </div>
	    </div>
    </div></div> ';
 }else if($id == 48477){
 $html ='<div class="open-close-section">
      <div class="open-close filter-item  open-close-no">
        <div class="opener-holder opener ">Options for Complete Outdoor 1x4 PLC Splitter</div>

        <div class="slide">
          <div class="sub-open-close sub-active">
            <div class="opener-holder">Option 1</div>
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0" width="100%">
                <tr>
                  <th>Equipped Qty (PCS)</th>
                  <th>ID#</th>
                  <th >Description</th>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/33185.html" target="_blank">33185</a></td>
                  <td >1×4 Fiber PLC Splitter in Mini plug-in Type</td>
                  
                </tr>
				 <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29661.html" target="_blank">29661</a></td>
                  <td >1x8 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                  
                </tr>
				<tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td >4-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                  
                </tr>
				<tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/14240.html" target="_blank">14240</a></td>
                  <td >Simplex 9/125 Single-mode LC/SC/ST/FC Pigtail</td>
                  
                </tr>
              </table>
            </div>
          </div>
        </div>
       
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder">Option 2</div>
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0" width="100%">
            <tr>
              <th>Equipped Qty (PCS)</th>
              <th>ID#</th>
              
              <th >Description</th>
              </tr>
                <tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/33185.html" target="_blank">33185</a></td>
                  <td>1×4 Fiber PLC Splitter in Mini plug-in Type</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29665.html" target="_blank">29665</a></td>
                  <td>1×16 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/14240.html" target="_blank">14240</a></td>
                  <td>Simplex 9/125 Single-mode LC/SC/ST/FC Pigtail</td>
                </tr>
        </table>
            </div>
          </div>
        </div>
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder">Option 3</div>
            <div class="sub-slide">
              <table width="100%" cellpadding="0" cellspacing="0" >
                <tr>
                  <th>Equipped Qty (PCS)</th>
                  <th>ID#</th>
                  <th>Description</th>
                </tr>
                <tr>
                  <td>4</td>
                  <td><a href="http://www.fs.com/products/33185.html" target="_blank">33185</a></td>
                  <td>1×4 Fiber PLC Splitter in Mini plug-in Type</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29664.html" target="_blank">29664</a></td>
                  <td>1x32 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                </tr>
				 <tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
				<tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>4-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
            </table>
            </div>
          </div>
        </div>
		
		
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder">Option 4</div>
            <div class="sub-slide">
              <table width="100%" cellpadding="0" cellspacing="0" >
                <tr>
                  <th>Equipped Qty (PCS)</th>
                  <th>ID#</th>
                  <th>Description</th>
                </tr>
                <tr>
                  <td>8</td>
                  <td><a href="http://www.fs.com/products/33185.html" target="_blank">33185</a></td>
                  <td>1×4 Fiber PLC Splitter in Mini plug-in Type</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29678.html" target="_blank">29678</a></td>
                  <td>1×64 Fiber Optical Splitter SPCC Terminal Box As Distribution Box</td>
                </tr>
				 <tr>
                  <td>4</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
				<tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
            </table>
            </div>
          </div>
	    </div>
    </div></div>';
 }else if($id == 48478){
 $html ='<div class="open-close-section">
      <div class="open-close filter-item  open-close-no">
        <div class="opener-holder opener ">Options for Complete Outdoor 1x8 PLC Splitter</div>

        <div class="slide">
          <div class="sub-open-close sub-active">
            <div class="opener-holder">Option 1</div>
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0" width="100%">
                <tr>
                  <th>Equipped Qty (PCS)</th>
                  <th>ID#</th>
                  <th >Description</th>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/33247.html" target="_blank">33247</a></td>
                  <td >1×8 Fiber PLC Splitter in Mini plug-in Type</td>
                  
                </tr>
				 <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29661.html" target="_blank">29661</a></td>
                  <td >1x8 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                  
                </tr>
				<tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td >8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                  
                </tr>
				<tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/14240.html" target="_blank">14240</a></td>
                  <td >Simplex 9/125 Single-mode LC/SC/ST/FC Pigtail</td>
                  
                </tr>
              </table>
            </div>
          </div>
        </div>
       
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder">Option 2</div>
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0" width="100%">
            <tr>
              <th>Equipped Qty (PCS)</th>
              <th>ID#</th>
              
              <th >Description</th>
              </tr>
                <tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/33247.html" target="_blank">33247</a></td>
                  <td>1×8 Fiber PLC Splitter in Mini plug-in Type</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29665.html" target="_blank">29665</a></td>
                  <td>1×16 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td><a href="http://www.fs.com/products/14240.html" target="_blank">14240</a></td>
                  <td>Simplex 9/125 Single-mode LC/SC/ST/FC Pigtail</td>
                </tr>
        </table>
            </div>
          </div>
        </div>
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder">Option 3</div>
            <div class="sub-slide">
              <table width="100%" cellpadding="0" cellspacing="0" >
                <tr>
                  <th>Equipped Qty (PCS)</th>
                  <th>ID#</th>
                  <th>Description</th>
                </tr>
                <tr>
                  <td>4</td>
                  <td><a href="http://www.fs.com/products/33247.html" target="_blank">33247</a></td>
                  <td>1×8 Fiber PLC Splitter in Mini plug-in Type</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29664.html" target="_blank">29664</a></td>
                  <td>1x32 Fiber Optical Splitter Terminal Box As Distribution Box</td>
                </tr>
				 <tr>
                  <td>4</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
				<tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>4-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
            </table>
            </div>
          </div>
        </div>
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder">Option 4</div>
            <div class="sub-slide">
              <table width="100%" cellpadding="0" cellspacing="0" >
                <tr>
                  <th>Equipped Qty (PCS)</th>
                  <th>ID#</th>
                  <th>Description</th>
                </tr>
                <tr>
                  <td>8</td>
                  <td><a href="http://www.fs.com/products/33247.html" target="_blank">33247</a></td>
                  <td>1×8 Fiber PLC Splitter in Mini plug-in Type</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/29678.html" target="_blank">29678</a></td>
                  <td>1×64 Fiber Optical Splitter SPCC Terminal Box As Distribution Box</td>
                </tr>
				 <tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>4-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
				<tr>
                  <td>1</td>
                  <td><a href="http://www.fs.com/products/21247.html" target="_blank">21247</a></td>
                  <td>8-fiber 0.9mm 9/125 Single-mode LC/SC/ST/FC Bunch Pigtail</td>
                </tr>
            </table>
            </div>
          </div>
	    </div>
    </div></div>';
 }

 return $html;
}

function fs_html_table_of_mux_oadm($cid,$pid){
  $html='';
  switch ($cid){
  case '177':
    if(in_array($pid,array(48409,48408,48407,48406,48405,48404,48403,48402,48401,48394,48393,48386,48385,48384,48383,43782,43781,43780,43779,43723,43722,43721,43720,43711,43699,43573,43557,43554,43553,43550,43547,43099,43097,42973,42972,42960,42959,42947,42946,42945,42944,42937,42830,33489,30427,30426,30412,30405))){
    $html ='<div class="open-close-section">
      <div class="open-close filter-item  open-close-no">
        <div class="opener-holder opener ">CWDM MUX DEMUXES SERIES</div>

        <div class="slide">
          <div class="sub-open-close sub-active">
            <div class="opener-holder">WHOLE BAND (1270-1610NM)</div>
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0" width="100%">
                <tr>
                  <th>Application</th>
                  <th>ID#</th>
                  <th >Description</th>
                </tr>
                <tr>
                  <td>Whole band<br />(1270-1610nm)</td>
                  <td><a href="http://www.fs.com/products/33489.html" target="_blank">33489</a></td>
                  <td >18 ch. CWDM Mux Demux, C27-C61, with monitor port, IL Link < 4.9dB, duplex LC/UPC</td>
                  
                </tr>
              </table>
            </div>
          </div>
        </div>
       
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder">HIGH BAND (1470-1610NM)</div>
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0" width="100%">
            <tr>
              <th>Application</th>
              <th>ID#</th>
              
              <th >Description</th>
              </tr>
                <tr>
                  <td>High band <br />(1470-1610nm)</td>
                  <td><a href="http://www.fs.com/products/43099.html" target="_blank">43099</a></td>
                  <td>8 ch. CWDM Mux Demux, C47-C61, with expansion port, IL Link &lt; 2.8dB, duplex LC/UPC</td>
                </tr>
                <tr>
                  <td>High band <br />(1470-1610nm)</td>
                  <td><a href="http://www.fs.com/products/43097.html" target="_blank">43097</a></td>
                  <td>8 ch. CWDM Mux Demux, C47-C61, IL Link &lt; 2.5dB, duplex LC/UPC</td>
                </tr>
                <tr>
                  <td>High band<br />(1470-1610nm)</td>
                  <td><a href="http://www.fs.com/products/42973.html" target="_blank">42973</a></td>
                  <td>4 ch. CWDM Mux Demux, C51-C57, with expansion port, IL Link &lt; 2.1dB, duplex LC/UPC</td>
                </tr>
                <tr>
                  <td>High band <br />(1470-1610nm)</td>
                  <td><a href="http://www.fs.com/products/42944.html" target="_blank">42944</a></td>
                  <td>4 ch. CWDM Mux Demux, C51-C57, IL Link &lt; 1.8dB, duplex LC/UPC</td>
                </tr>
        </table>
            </div>
          </div>
        </div>
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder">LOW BAND (1270-1430NM)</div>
            <div class="sub-slide">
              <table width="100%" cellpadding="0" cellspacing="0" >
                <tr>
                  <th>Application</th>
                  <th>ID#</th>
                  <th>Description</th>
                </tr>
                <tr>
                  <td>Low band <br />(1270-1430nm)</td>
                  <td><a href="http://www.fs.com/products/42945.html" target="_blank">42945</a></td>
                  <td>8 ch. CWDM Mux Demux, C29-C43, IL < 2.5dB, duplex LC/UPC, Expansion Mux Demux to ID#43099</td>
                </tr>
                <tr>
                  <td>Low band <br />(1270-1430nm)</td>
                  <td><a href="http://www.fs.com/products/42972.html" target="_blank">42972</a></td>
                  <td>4 ch. CWDM Mux Demux, C27-C33, IL < 1.8dB, duplex LC/UPC, Expansion Mux Demux to ID#42973</td>
                </tr>
            </table>
            </div>
          </div>
        </div>
        <div class="slide" >
          <div class="sub-open-close">
            <div class="opener-holder">SINGLE FIBER</div>
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0">
            <tr>
              <th>Application</th>
              <th>ID#</th>
              <th>Description</th>
              </tr>
            <tr>
              <td>Single fiber</td>
              <td><a href="http://www.fs.com/products/43699.html" target="_blank">43699</a></td>
              <td>9 ch. CWDM Mux Demux, single fiber, C29 C33 C37 C41 C45 C49 C53 C57, C61, for transceiver wavelengths, <br>
                IL &lt; 2.8dB, LC/UPC, combined with ID#43711</td>
              </tr>
            <tr>
              <td>Single fiber</td>
              <td><a href="http://www.fs.com/products/43711.html" target="_blank">43711</a></td>
              <td>9 ch. CWDM Mux Demux, single fiber, C27 C31 C39 C35 C43 C47 C51 C55 C59, for transceiver wavelengths, <br>
                IL &lt; 2.8dB, LC/UPC, combined with ID#43699</td>
              </tr>
            <tr>
              <td>Single fiber</td>
              <td><a href="http://www.fs.com/products/43780.html" target="_blank">43780</a></td>
              <td>8 ch. CWDM Mux Demux, single fiber, C29 C33 C37 C41 C47 C51 C55 C59, for transceiver wavelengths, <br>
                IL &lt; 2.5dB, LC/UPC, combined with ID#43779</td>
              </tr>
            <tr>
              <td>Single fiber</td>
              <td><a href="http://www.fs.com/products/43779.html" target="_blank">43779</a></td>
              <td>8 ch. CWDM Mux Demux, single fiber, C31 C35 C39 C43 C49 C53 C57 C61, for transceiver wavelengths, <br>
                IL &lt; 2.5dB, LC/UPC, combined with ID#43780</td>
              </tr>
            <tr>
              <td>Single fiber</td>
              <td><a href="http://www.fs.com/products/48393.html" target="_blank">48393</a></td>
              <td>4 ch. CWDM Mux Demux, single fiber, C47 C51 C55 C59, for transceiver wavelengths, <br>
                with expansion port, IL &lt; 2.1dB, LC/UPC, combined with ID#48394</td>
              </tr>
            <tr>
              <td>Single fiber</td>
              <td><a href="http://www.fs.com/products/48394.html" target="_blank">48394</a></td>
              <td>4 ch. CWDM Mux Demux, single fiber, C49 C53 C57 C61, for transceiver wavelengths, <br>
                with expansion port, IL &lt; 2.1dB, LC/UPC, combined with ID#48393</td>
              </tr>
            <tr>
              <td>Single fiber</td>
              <td><a href="http://www.fs.com/products/43554.html" target="_blank">43554</a></td>
              <td>4 ch. CWDM Mux Demux, single fiber, C47 C51 C55 C59, for transceiver wavelengths, <br>
                IL &lt; 1.8dB, LC/UPC, combined with ID#43553</td>
              </tr>
            <tr>
              <td>Single fiber</td>
              <td><a href="http://www.fs.com/products/43553.html" target="_blank">43553</a></td>
              <td>4 ch. CWDM Mux Demux, single fiber, C49 C53 C57 C61, for transceiver wavelengths, <br>
                IL &lt; 1.8dB, LC/UPC, combined with ID#43554</td>
              </tr>
        </table>

            </div>
          </div>
        </div>
      </div>
    </div>';
    }
  break;
  case '178':
   if(in_array($pid,array(61647,61646,50135,50134,50133,50132,50128,50127,50126,50125,50124,50123,50122,50121,50120,50119,50118,50117,50116,35887,35886,33485,11585))){
   $html='<div class="open-close-section">
      <div class="open-close filter-item  open-close-no">
        <div class="opener-holder opener ">DWDM MUX DEMUXS SERIES</div>
        <!--第一个表格-->
        <div class="slide">
          <div class="sub-open-close sub-active">
            <div class="opener-holder">80 CHANNEL</div>
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0" width="100%">
                <tbody><tr>
                  <th>Application</th>
                  <th>ID#</th>
                  <th>Description</th>
                </tr>
                <tr>
                  <td>80 channel</td>
                  <td><a href="http://www.fs.com/products/50120.html" target="_blank">50120</a></td>
                  <td>80 ch. DWDM Mux Demux, 50GHz, CH21-CH60, with expansion port, IL=10.5dB, duplex LC/UPC</td> 
                </tr>
 <tr>
                  <td>80 channel</td>
                  <td><a href="http://www.fs.com/products/50121.html" target="_blank">50121</a></td>
                  <td>80 ch. DWDM Mux Demux, 50GHz, CH21-CH60, IL=8.0dB, duplex LC/UPC</td> 
                </tr>
              </tbody></table>
            </div>
          </div>
        </div>
         <!--第二个表格-->
        <div class="slide">
          <div class="sub-open-close sub-active">
            <div class="opener-holder">40/32/16 CHANNEL</div>
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0" width="100%">
                <tbody><tr>
                  <th>Application</th>
                  <th>ID#</th>
                  <th>Description</th>
                </tr>
                <tr>
                  <td>40 channel</td>
                  <td><a href="http://www.fs.com/products/33485.html" target="_blank">33485</a></td>
                  <td>40 ch. DWDM Mux Demux, 100GHz, C21-C60, with monitor port, 3.0dB typical IL, 4.5dB max IL, duplex LC/UPC</td> 
                </tr>
<tr>
                  <td>40 channel</td>
                  <td><a href="http://www.fs.com/products/35886.html" target="_blank">35886</a></td>
                  <td>40 ch. DWDM Mux Demux, 100GHz, C21-C60, with monitor port, 5.5dB typical IL, 6.4dB max IL, duplex LC/UPC</td> 
                </tr>
<tr>
                  <td>40 channel</td>
                  <td><a href="http://www.fs.com/products/35887.html" target="_blank">35887</a></td>
                  <td>40 ch. DWDM Mux Demux, 100GHz, C21-C60, with monitor port and 1310nm port, 3.5dB typical IL, 5.0dB max IL, duplex LC/UPC</td> 
                </tr>
<tr>
                  <td>32 channel</td>
                  <td><a href="http://www.fs.com/products/50122.html" target="_blank">50122</a></td>
                  <td>32 ch. DWDM Mux Demux, 100GHz, C21-C52, IL=5.5dB, duplex LC/UPC</td> 
                </tr>
<tr>
                  <td>16 channel</td>
                  <td><a href="http://www.fs.com/products/50123.html" target="_blank">50123</a></td>
                  <td>16 ch. DWDM Mux Demux, 100GHz, C21-C36, with expansion port, IL=4.5dB, duplex LC/UPC</td> 
                </tr>
<tr>
                  <td>16 channel</td>
                  <td><a href="http://www.fs.com/products/50124.html" target="_blank">50124</a></td>
                  <td>16 ch. DWDM Mux Demux, 100GHz, C21-C36, IL=5.0dB, duplex LC/UPC</td> 
                </tr>

              </tbody></table>
            </div>
          </div>
        </div>
 <!--第三个表格-->
        <div class="slide">
          <div class="sub-open-close sub-active">
            <div class="opener-holder">8 CHANNEL SINGLE FIBER</div>
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0" width="100%">
                <tbody><tr>
                  <th>Application</th>
                  <th>ID#</th>
                  <th>Description</th>
                </tr>
                <tr>
                  <td>8 channel single fiber</td>
                  <td><a href="http://www.fs.com/products/50116.html" target="_blank">50116</a></td>
                  <td>8 ch. DWDM Mux Demux, 100GHz, C22-C36 for transceiver wavelengths, with expansion port, IL =4.3dB, LC/UPC, </br>combined with ID#50117</td> 
                </tr>
 <tr>
                  <td>8 channel single fiber</td>
                  <td><a href="http://www.fs.com/products/50117.html" target="_blank">50117</a></td>
                  <td>8 ch. DWDM Mux Demux, 100GHz, C21-C35 for transceiver wavelengths, with expansion port, IL=4.3dB, LC/UPC, </br>combined with ID#50116</td> 
                </tr>

<tr>
                  <td>8 channel single fiber</td>
                  <td><a href="http://www.fs.com/products/50118.html" target="_blank">50118</a></td>
                  <td>8 ch. DWDM Mux Demux, 100GHz, C44-C58 for transceiver wavelengths, IL=3.8dB, LC/UPC, </br>combined with ID#50119</td> 
                </tr>
<tr>
                  <td>8 channel single fiber</td>
                  <td><a href="http://www.fs.com/products/50119.html" target="_blank">50119</a></td>
                  <td>8 ch. DWDM Mux Demux, 100GHz, C43-C57 for transceiver wavelengths, IL=3.8dB, LC/UPC, </br>combined with ID#50118</td> 
                </tr>
              </tbody></table>
            </div>
          </div>
        </div>
</div></div>';
   }
  break;
  case '179':
  if(in_array($pid,array(50583,50582,50581,50580,50579,50578,50577,50576,50575,50574,50573,50572,50571,50570,50569,50568,50567,50566,50565,50564,50563,50562,50561,50560,50559,50558,50557,50556,50555,50554))){
  $html='<div class="open-close-section">
      <div class="open-close filter-item  open-close-no">
        <div class="opener-holder opener ">CWDM OADMS SERIES</div>
        <div class="slide">
          <div class="sub-open-close sub-active">
            <div class="opener-holder">DUAL FIBER</div>
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0" width="100%">
                <tbody><tr>
                  <th>Application</th>
                  <th>ID#</th>
                  <th>Description</th>
                </tr>
                <tr>
                  <td>Dual fiber</td>
                  <td><a href="http://www.fs.com/products/50554.html" target="_blank">50554</a></td>
                  <td>1 ch. CWDM OADM, East-and-West, IL=0.6dB, duplex LC/UPC</td> 
                </tr>
<tr>
                  <td>Dual fiber</td>
                  <td><a href="http://www.fs.com/products/50555.html" target="_blank">50555</a></td>
                  <td>2 ch. CWDM OADM, East-and-West, IL=1.0dB, duplex LC/UPC</td> 
                </tr>
<tr>
                  <td>Dual fiber</td>
                  <td><a href="http://www.fs.com/products/50556.html" target="_blank">50556</a></td>
                  <td>4 ch. CWDM OADM, East-and-West, IL=1.7dB, duplex LC/UPC</td> 
                </tr>
<tr>
                  <td>Dual fiber</td>
                  <td><a href="http://www.fs.com/products/50557.html" target="_blank">50557</a></td>
                  <td>1 ch. CWDM OADM, East-or-West, IL=0.6dB, duplex LC/UPC</td> 
                </tr>
<tr>
                  <td>Dual fiber</td>
                  <td><a href="http://www.fs.com/products/50558.html" target="_blank">50558</a></td>
                  <td>2 ch. CWDM OADM, East-or-West, IL=1.0dB, duplex LC/UPC</td> 
                </tr>
 </tr>
<tr>
                  <td><a href="/products/33489.html" target="_blank">Dual fiber</a></td>
                  <td><a href="http://www.fs.com/products/50559.html" target="_blank">50559</a></td>
                  <td>4 ch. CWDM OADM, East-or-West, IL=1.7dB, duplex LC/UPC</td> 
                </tr>
              </tbody></table>
            </div>
          </div>
        </div>
        <div class="slide">
          <div class="sub-open-close sub-active">
            <div class="opener-holder">SINGLE FIBER</div>
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0" width="100%">
                <tbody><tr>
                  <th>Application</th>
                  <th>ID#</th>
                  <th>Description</th>
                </tr>
                <tr>
                  <td>Single fiber</td>
                  <td><a href="http://www.fs.com/products/50572.html" target="_blank">50572</a></td>
                  <td>1 ch. CWDM OADM, single fiber, East-and-West, IL=0.6dB, LC/UPC </td> 
                </tr>
<tr>
                  <td>Single fiber</td>
                  <td><a href="http://www.fs.com/products/50573.html" target="_blank">50573</a></td>
                  <td>2 ch. CWDM OADM, single fiber, East-and-West, IL=1.0dB, LC/UPC </td> 
                </tr>
<tr>
                  <td>Single fiber</td>
                  <td><a href="http://www.fs.com/products/50578.html" target="_blank">50578</a></td>
                  <td>1 ch. CWDM OADM, single fiber, East-or-West, IL=0.6dB, LC/UPC </td> 
                </tr>
<tr>
                  <td>Single fiber</td>
                  <td><a href="http://www.fs.com/products/50579.html" target="_blank">50579</a></td>
                  <td>2 ch. CWDM OADM, single fiber, East-or-West, IL=1.0dB, LC/UPC </td> 
                </tr>
              </tbody></table>
            </div>
          </div>
        </div>
	</div>
</div>';
  }
  break;
  case '180':
  if(in_array($pid,array(51828,51827,51826,51825,51824,51823,51822,51821,51820,51819,51818,51817,51816,51815,51814,51813,51812,51811,51810,51809,51808,51807,51806,51805,51804,51803,51802,51801,51800,51799,51798,51797,51796))){
  $html=' <div class="open-close-section">
      <div class="open-close filter-item  open-close-no">
        <div class="opener-holder opener ">DWDM OADMS SERIES</div>
       
        <div class="slide">
          <div class="sub-open-close sub-active">
            <div class="opener-holder">DUAL FIBER</div>
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0" width="100%">
                <tbody><tr>
                  <th>Application</th>
                  <th>ID#</th>
                  <th>Description</th>
                </tr>
                <tr>
                  <td>Dual fiber</td>
                  <td><a href="http://www.fs.com/products/51796.html" target="_blank">51796</a></td>
                  <td>1 ch. DWDM OADM 100GHz, East-and-West, IL=1.0dB, duplex LC/UPC </td> 
                </tr>
<tr>
                  <td>Dual fiber</td>
                  <td><a href="http://www.fs.com/products/51797.html" target="_blank">51797</a></td>
                  <td>2 ch. DWDM OADM 100GHz, East-and-West, IL=1.5dB, duplex LC/UPC </td> 
                </tr>
<tr>
                  <td>Dual fiber</td>
                  <td><a href="http://www.fs.com/products/51798.html" target="_blank">51798</a></td>
                  <td>4 ch. DWDM OADM 100GHz, East-and-West, IL=1.8dB, duplex LC/UPC </td> 
                </tr>
<tr>
                  <td>Dual fiber</td>
                  <td><a href="http://www.fs.com/products/51799.html" target="_blank">51799</a></td>
                  <td>1 ch. DWDM OADM 100GHz, East-or-West, IL=1.0dB, duplex LC/UPC </td> 
                </tr>
<tr>
                  <td>Dual fiber</td>
                  <td><a href="http://www.fs.com/products/51800.html" target="_blank">51800</a></td>
                  <td>2 ch. DWDM OADM 100GHz, East-or-West, IL=1.5dB, duplex LC/UPC </td> 
                </tr>
 </tr>
<tr>
                  <td>Dual fiber</td>
                  <td><a href="http://www.fs.com/products/51801.html" target="_blank">51801</a></td>
                  <td>4 ch. DWDM OADM 100GHz, East-or-West, IL=1.8dB, duplex LC/UPC </td> 
                </tr>
<tr>
                  <td>Dual fiber</td>
                  <td><a href="http://www.fs.com/products/51802.html" target="_blank">51802</a></td>
                  <td>8 ch. DWDM OADM 100GHz, East-or-West, IL=3.0dB, duplex LC/UPC  </td> 
                </tr>
              </tbody></table>
            </div>
          </div>
        </div>
       
        <div class="slide">
          <div class="sub-open-close sub-active">
            <div class="opener-holder">SINGLE FIBER</div>
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0" width="100%">
                <tbody><tr>
                  <th>Application</th>
                  <th>ID#</th>
                  <th>Description</th>
                </tr>
                <tr>
                  <td>Single fiber</td>
                  <td><a href="http://www.fs.com/products/51819.html" target="_blank">51819</a></td>
                  <td>1 ch. DWDM OADM 100GHz, single fiber, East-and-West, IL=1.0dB, LC/UPC  </td> 
                </tr>
<tr>
                  <td>Single fiber</td>
                  <td><a href="http://www.fs.com/products/51820.html" target="_blank">51820</a></td>
                  <td>2 ch. DWDM OADM 100GHz, single fiber, East-and-West, IL=1.5dB, LC/UPC </td> 
                </tr>
<tr>
                  <td>Single fiber</td>
                  <td><a href="http://www.fs.com/products/51823.html" target="_blank">51823</a></td>
                  <td>1 ch. DWDM OADM 100GHz, single fiber, East-or-West, IL=1.0dB, LC/UPC  </td> 
                </tr>
<tr>
                  <td>Single fiber</td>
                  <td><a href="http://www.fs.com/products/51824.html" target="_blank">51824</a></td>
                  <td>2 ch. DWDM OADM 100GHz, single fiber, East-or-West, IL=1.5dB, LC/UPC </td> 
                </tr>
              </tbody></table>
            </div>
          </div>
        </div>
	 </div>
  </div>';
  }
  break;
  default:
  break;
  }
  return $html;
}


function fs_html_of_40g_BPDF($pid){
	$html = '';

	if(in_array($pid,array(36189,36191,36205,36199,36202,36206,36207,51714,36196))){
		$html .= '<div class="open-close-section">
		  <div class="open-close filter-item"> 
			<div class="opener-holder opener ">Arista Networks 40G QSFP+ Transceivers Series</div>
			
			<div class="slide" >
			  <div class="sub-open-close">
				<div class="sub-slide">
				  <table cellspacing="0" cellpadding="0">
				<tr>
				  <th>Aplication</th>
				  <th align="center">Part Number</th>
				  <th>Description</th>
				  <th>&nbsp;</th>
				</tr>
				<tr>
				  <td><a href="/products/36189.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/36189.html" target="_blank">QSFP-40G-SR4</a></td>
				  <td>QSFP, 40GBase-SR, 850nm, MMF, 100m@OM3, 150m@OM4, MTP/MPO, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/QSFP-40G-SR4.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/36191.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/36191.html" target="_blank">QSFP-40G-XSR4</a></td>
				  <td>QSFP, 40GBase-SR, 850nm, MMF, 300m@OM3, 400m@OM4, MTP/MPO, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/QSFP-40G-XSR4.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/51714.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/51714.html" target="_blank">QSFP-40G-SRBD</a></td>
				  <td>QSFP, 40GBase-SR, 850nm, MMF, 30m@OM2, 100m@OM3, 150m@OM4, Bi-Directional Duplex LC, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/QSFP-BD-40G.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/36205.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/36205.html" target="_blank">QSFP-40G-PLRL4</a></td>
				  <td>QSFP, 40GBase-LR, 1310nm, SMF, 1.4km, MTP/MPO, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/QSFP-40G-PLRL4.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/36196.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/36196.html" target="_blank">QSFP-40G-UNIV</a></td>
				  <td>QSFP, 40GBase-LR, CWDM 1270-1330nm, 150m @ OM3/OM4, 2km over SMF, LC, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/QSFP-40G-UNIV.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/36199.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/36199.html" target="_blank">QSFP-40G-LRL4</a></td>
				  <td>QSFP, 40GBase-LR, CWDM 1270-1330nm, SMF, 2km, LC, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/QSFP-40G-LRL4.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/36202.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/36202.html" target="_blank">QSFP-40G-LR4</a></td>
				  <td>QSFP, 40GBase-LR, CWDM 1270-1330nm, SMF, 10km, LC, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/QSFP-40G-LR4.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/36206.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/36206.html" target="_blank">QSFP-40G-PLR4</a></td>
				  <td>QSFP, 40GBase-LR, 1310nm, SMF, 10km, MTP/MPO, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/QSFP-40G-PLR4.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/36207.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/36207.html" target="_blank">QSFP-40G-ER4</a></td>
				  <td>QSFP, 40GBase-ER, CWDM 1270-1330nm, SMF, 40km, LC, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/QSFP-40G-ER4.pdf" target="_blank" class="download">download</a></td>
				</tr>
			</table>

				</div>
			  </div>
			</div>
		  </div>
		</div>';
		}else if(in_array($pid,array(36182,36183,36184,48278,48733,36185,48280,48300,36442))){
		$html .='<div class="open-close-section">
		  <div class="open-close filter-item"> 
			<div class="opener-holder opener ">Brocade 40G QSFP+ Transceivers Series</div>
			
			<div class="slide" >
			  <div class="sub-open-close">
				<div class="sub-slide">
				  <table cellspacing="0" cellpadding="0">
				<tr>
				  <th>Aplication</th>
				  <th align="center">Part Number</th>
				  <th>Description</th>
				  <th>&nbsp;</th>
				</tr>
				<tr>
				  <td><a href="/products/36182.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/36182.html" target="_blank">40G-QSFP-SR4</a></td>
				  <td>QSFP, 40GBase-SR, 850nm, MMF, 100m@OM3, 150m@OM4, MTP/MPO, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/40G-QSFP-SR4.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/36184.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/36184.html" target="_blank">40G-QSFP-ESR4</a></td>
				  <td>QSFP, 40GBase-SR, 850nm, MMF, 300m@OM3, 400m@OM4, MTP/MPO, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/40G-QSFP-ESR4.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/48278.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/48278.html" target="_blank">QSFP-40G-PLRL4</a></td>
				  <td>QSFP, 40GBase-LR, 1310nm, SMF, 1.4km, MTP/MPO, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/QSFP-40G-PLRL4.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/36442.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/36442.html" target="_blank">40G-QSFP-LM4</a></td>
				  <td>QSFP, 40GBase-LR, CWDM 1270-1330nm, 150m @ OM3/OM4, 2km over SMF, LC, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/40G-QSFP-LM4.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/48733.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/48733.html" target="_blank">40G-QSFP-LR4L</a></td>
				  <td>QSFP, 40GBase-LR, CWDM 1270-1330nm, SMF, 2km, LC, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/40G-QSFP-LR4L.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/36185.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/36185.html" target="_blank">40G-QSFP-LR4</a></td>
				  <td>QSFP, 40GBase-LR, CWDM 1270-1330nm, SMF, 10km, LC, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/40G-QSFP-LR4.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/48280.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/48280.html" target="_blank">QSFP-40G-PLR4</a></td>
				  <td>QSFP, 40GBase-LR, 1310nm, SMF, 10km, MTP/MPO, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/QSFP-40G-PLR4.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/48300.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/48300.html" target="_blank">QSFP-40G-ER4</a></td>
				  <td>QSFP, 40GBase-ER, CWDM 1270-1330nm, SMF, 40km, LC, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/QSFP-40G-ER4.pdf" target="_blank" class="download">download</a></td>
				</tr>
			</table>

				</div>
			  </div>
			</div>
		  </div>
		</div>';		
		}else if(in_array($pid,array(36157,36165,36172,48276,36170,37016,36173,48722,36143,36153,36171,48724))){
		$html .='<div class="open-close-section">
		  <div class="open-close filter-item"> 
			<div class="opener-holder opener ">Cisco 40G QSFP+ Transceivers Series</div>
			
			<div class="slide" >
			  <div class="sub-open-close">
				<div class="sub-slide">
				  <table cellspacing="0" cellpadding="0">
				<tr>
				  <th>Aplication</th>
				  <th align="center">Part Number</th>
				  <th>Description</th>
				  <th>&nbsp;</th>
				</tr>
				<tr>
				  <td><a href="/products/36157.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/36157.html" target="_blank">QSFP-40G-SR4</a></td>
				  <td>QSFP, 40GBase-SR, 850nm, MMF, 100m@OM3, 150m@OM4, MTP/MPO, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/QSFP-40G-SR4.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/36165.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/36165.html" target="_blank">QSFP-40G-CSR4</a></td>
				  <td>QSFP, 40GBase-SR, 850nm, MMF, 300m@OM3, 400m@OM4, MTP/MPO, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/QSFP-40G-CSR4.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/48722.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/48722.html" target="_blank">QSFP-40G-SR-BD</a></td>
				  <td>QSFP, 40GBase-SR, 850nm, MMF, 30m@OM2, 100m@OM3, 150m@OM4, Bi-Directional Duplex LC, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/QSFP-BD-40G.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/48276.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/48276.html" target="_blank">QSFP-40G-PLRL4</a></td>
				  <td>QSFP, 40GBase-LR, 1310nm, SMF, 1.4km, MTP/MPO, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/QSFP-40G-PLRL4.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/48724.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/48724.html" target="_blank">QSFP-40G-UNIV</a></td>
				  <td>QSFP, 40GBase-LR, CWDM 1270-1330nm, 150m @ OM3/OM4, 2km over SMF, LC, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/QSFP-40G-UNIV.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/36172.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/36172.html" target="_blank">WSP-Q40GLR4L</a></td>
				  <td>QSFP, 40GBase-LR, CWDM 1270-1330nm, SMF, 2km, LC, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/QSFP-40G-LRL4.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/36170.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/36170.html" target="_blank">QSFP-40GE-LR4</a></td>
				  <td>QSFP, 40GBase-LR, CWDM 1270-1330nm, SMF, 10km, LC, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/QSFP-40G-LR4.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/37016.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/37016.html" target="_blank">QSFP-4X10G-LR-S</a></td>
				  <td>QSFP, 40GBase-LR, 1310nm, SMF, 10km, MTP/MPO, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/QSFP-4X10G-LR-S.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/36173.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/36173.html" target="_blank">QSFP-40G-ER4</a></td>
				  <td>QSFP, 40GBase-ER, CWDM 1270-1330nm, SMF, 40km, LC, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/QSFP-40G-ER4.pdf" target="_blank" class="download">download</a></td>
				</tr>
			</table>

				</div>
			  </div>
			</div>
		  </div>

		</div>';
		}else if(in_array($pid,array(17931,34912,34913,34917,24422,35209,35211,48721,35205))){
		$html .='<div class="open-close-section">
		  <div class="open-close filter-item"> 
			<div class="opener-holder opener ">Generic 40G QSFP+ Transceivers Series</div>
			
			<div class="slide" >
			  <div class="sub-open-close">
				<div class="sub-slide">
				  <table cellspacing="0" cellpadding="0">
				<tr>
				  <th>Aplication</th>
				  <th align="center">Part Number</th>
				  <th>Description</th>
				  <th>&nbsp;</th>
				</tr>
				<tr>
				  <td><a href="/products/17931.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/17931.html" target="_blank">QSFP-SR4-40G</a></td>
				  <td>QSFP, 40GBase-SR, 850nm, MMF, 100m@OM3, 150m@OM4, MTP/MPO, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/QSFP-SR4-40G.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/34912.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/34912.html" target="_blank">QSFP-CSR4-40G</a></td>
				  <td>QSFP, 40GBase-SR, 850nm, MMF, 300m@OM3, 400m@OM4, MTP/MPO, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/QSFP-CSR4-40G.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/48721.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/48721.html" target="_blank">QSFP-BD-40G</a></td>
				  <td>QSFP, 40GBase-SR, 850nm, MMF, 30m@OM2, 100m@OM3, 150m@OM4, Bi-Directional Duplex LC, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/QSFP-BD-40G.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/34917.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/34917.html" target="_blank">QSFP-PIR4-40G</a></td>
				  <td>QSFP, 40GBase-LR, 1310nm, SMF, 1.4km, MTP/MPO, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/QSFP-PIR4-40G.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/35205.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/35205.html" target="_blank">QSFP-LX4-40G</a></td>
				  <td>QSFP, 40GBase-LR, CWDM 1270-1330nm, 150m @ OM3/OM4, 2km over SMF, LC, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/QSFP-LX4-40G.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/34913.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/34913.html" target="_blank">QSFP-IR4-40G</a></td>
				  <td>QSFP, 40GBase-LR, CWDM 1270-1330nm, SMF, 2km, LC, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/QSFP-IR4-40G.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/24422.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/24422.html" target="_blank">QSFP-LR4-40G</a></td>
				  <td>QSFP, 40GBase-LR, CWDM 1270-1330nm, SMF, 10km, LC, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/QSFP-LR4-40G.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/35209.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/35209.html" target="_blank">QSFP-PLR4-40G</a></td>
				  <td>QSFP, 40GBase-LR, 1310nm, SMF, 10km, MTP/MPO, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/QSFP-PLR4-40G.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/35211.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/35211.html" target="_blank">QSFP-ER4-40G</a></td>
				  <td>QSFP, 40GBase-ER, CWDM 1270-1330nm, SMF, 40km, LC, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/QSFP-ER4-40G.pdf" target="_blank" class="download">download</a></td>
				</tr>
			</table>

				</div>
			  </div>
			</div>
		  </div>
		</div>';
		}else if(in_array($pid,array(36181,36178,36176,36177,36126,36174,48299,36179,36180,36439,36440,36065,36114,36120,36132,36441,36175))){
		$html .='<div class="open-close-section">
		  <div class="open-close filter-item"> 
			<div class="opener-holder opener ">Juniper Networks 40G QSFP+ Transceivers Series</div>
			
			<div class="slide" >
			  <div class="sub-open-close">
				<div class="sub-slide">
				  <table cellspacing="0" cellpadding="0">
				<tr>
				  <th>Aplication</th>
				  <th align="center">Part Number</th>
				  <th>Description</th>
				  <th>&nbsp;</th>
				</tr>
				<tr>
				  <td><a href="/products/36181.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/36181.html" target="_blank">EX-QSFP-40GE-SR4</a></td>
				  <td>QSFP, 40GBase-SR, 850nm, MMF, 100m@OM3, 150m@OM4, MTP/MPO, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/EX-QSFP-40GE-SR4.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/36178.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/36178.html" target="_blank">QFX-QSFP-40G-ESR4</a></td>
				  <td>QSFP, 40GBase-SR, 850nm, MMF, 300m@OM3, 400m@OM4, MTP/MPO, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/QFX-QSFP-40G-ESR4.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/36176.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/36176.html" target="_blank">JNP-QSFP-4X10GE-IR</a></td>
				  <td>QSFP, 40GBase-LR, 1310nm, SMF, 1.4km, MTP/MPO, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/JNP-QSFP-4X10GE-IR.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/36175.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/36175.html" target="_blank">JNP-QSFP-40G-LX4</a></td>
				  <td>QSFP, 40GBase-LR, CWDM 1270-1330nm, 150m @ OM3/OM4, 2km over SMF, LC, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/JNP-QSFP-40G-LX4.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/36177.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/36177.html" target="_blank">JNP-QSFP-40GE-IR4</a></td>
				  <td>QSFP, 40GBase-LR, CWDM 1270-1330nm, SMF, 2km, LC, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/JNP-QSFP-40GE-IR4.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/36126.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/36126.html" target="_blank">EX-QSFP-40GE-LR4</a></td>
				  <td>QSFP, 40GBase-LR, CWDM 1270-1330nm, SMF, 10km, LC, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/EX-QSFP-40GE-LR4.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/36174.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/36174.html" target="_blank">JNP-QSFP-4X10GE-LR</a></td>
				  <td>QSFP, 40GBase-LR, 1310nm, SMF, 10km, MTP/MPO, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/JNP-QSFP-4X10GE-LR.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/48299.html" target="_blank">Standard 40G QSFP+</a></td>
				  <td><a href="/products/48299.html" target="_blank">QSFP-40G-ER4</a></td>
				  <td>QSFP, 40GBase-ER, CWDM 1270-1330nm, SMF, 40km, LC, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/QSFP-40G-ER4.pdf" target="_blank" class="download">download</a></td>
				</tr>
			</table>

				</div>
			  </div>
			</div>
		  </div>
		</div>';
		}else{
		$html ='';
		}
	return $html;
}

function fs_html_of_100g_BPDF($pid){
	$html = '';
	if(in_array($pid,array(48852,48853))){
		$html .='<div class="open-close-section">
		  <div class="open-close filter-item"> 
			<div class="opener-holder opener ">Arista Networks 100G QSFP28 Transceivers Series</div>
		
			<div class="slide" >
			  <div class="sub-open-close">
				<div class="sub-slide">
				  <table cellspacing="0" cellpadding="0">
				<tr>
				  <th>Aplication</th>
				  <th align="center">Part Number</th>
				  <th>Description</th>
				  <th>&nbsp;</th>
				</tr>
				<tr>
				  <td><a href="/products/48852.html" target="_blank">Standard 100G QSFP28</a></td>
				  <td><a href="/products/48852.html" target="_blank">QSFP-100G-SR4</a></td>
				  <td>QSFP28, 100GBase-SR4, 850nm, MMF, 100m@OM3, 150m@OM4, MTP/MPO, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/QSFP-100G-SR4.pdf" type="application/pdf; length=882099" title="QSFP-100G-SR4.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/48853.html" target="_blank">Standard 100G QSFP28</a></td>
				  <td><a href="/products/48853.html" target="_blank">QSFP-100G-LR4</a></td>
				  <td>QSFP28, 100GBase-LR4, 1310nm, SMF, 10km, LC, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/QSFP-100G-LR4.pdf" target="_blank" class="download">download</a></td>
				</tr>
			</table>

				</div>
			  </div>
			</div>
		  </div>
		</div>';
	}else if(in_array($pid,array(48854,48855))){
		$html .= '<div class="open-close-section">
		  <div class="open-close filter-item"> 
			<div class="opener-holder opener ">Brocade 100G QSFP28 Transceivers Series</div>
			<div class="slide" >
			  <div class="sub-open-close">
				<div class="sub-slide">
				  <table cellspacing="0" cellpadding="0">
				<tr>
				  <th>Aplication</th>
				  <th align="center">Part Number</th>
				  <th>Description</th>
				  <th>&nbsp;</th>
				</tr>
				<tr>
				  <td><a href="/products/48854.html" target="_blank">Standard 100G QSFP28</a></td>
				  <td><a href="/products/48854.html" target="_blank">100G-QSFP28-SR4</a></td>
				  <td>QSFP28, 100GBase-SR4, 850nm, MMF, 100m@OM3, 150m@OM4, MTP/MPO, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/100G-QSFP28-SR4.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/48855.html" target="_blank">Standard 100G QSFP28</a></td>
				  <td><a href="/products/48855.html" target="_blank">100G-QSFP28-LR4-10KM</a></td>
				  <td>QSFP28, 100GBase-LR4, 1310nm, SMF, 10km, LC, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/100G-QSFP28-LR4-10KM.pdf" target="_blank" class="download">download</a></td>
				</tr>
			</table>

				</div>
			  </div>
			</div>
		  </div>
		</div>';
	}else if(in_array($pid,array(48354,48355))){
		$html .='<div class="open-close-section">
		  <div class="open-close filter-item"> 
			<div class="opener-holder opener ">Cisco 100G QSFP28 Transceivers Series</div>
			<div class="slide" >
			  <div class="sub-open-close">
				<div class="sub-slide">
				  <table cellspacing="0" cellpadding="0">
				<tr>
				  <th>Aplication</th>
				  <th align="center">Part Number</th>
				  <th>Description</th>
				  <th>&nbsp;</th>
				</tr>
				<tr>
				  <td><a href="/products/48354.html" target="_blank">Standard 100G QSFP28</a></td>
				  <td><a href="/products/48354.html" target="_blank">QSFP-100G-SR4-S</a></td>
				  <td>QSFP28, 100GBase-SR4, 850nm, MMF, 100m@OM3, 150m@OM4, MTP/MPO, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/QSFP-100G-SR4-S.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/48355.html" target="_blank">Standard 100G QSFP28</a></td>
				  <td><a href="/products/48355.html" target="_blank">QSFP-100G-LR4-S</a></td>
				  <td>QSFP28, 100GBase-LR4, 1310nm, SMF, 10km, LC, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/QSFP-100G-LR4-S.pdf" target="_blank" class="download">download</a></td>
				</tr>
			</table>

				</div>
			  </div>
			</div>
		  </div>
		</div>';
	}else if(in_array($pid,array(35182,39025))){
		$html .= '<div class="open-close-section">
		  <div class="open-close filter-item"> 
			<div class="opener-holder opener ">Generic 100G QSFP28 Transceivers Series</div>
			<div class="slide" >
			  <div class="sub-open-close">
				<div class="sub-slide">
				  <table cellspacing="0" cellpadding="0">
				<tr>
				  <th>Aplication</th>
				  <th align="center">Part Number</th>
				  <th>Description</th>
				  <th>&nbsp;</th>
				</tr>
				<tr>
				  <td><a href="/products/35182.html" target="_blank">Standard 100G QSFP28</a></td>
				  <td><a href="/products/35182.html" target="_blank">QSFP28-SR4-100G</a></td>
				  <td>QSFP28, 100GBase-SR4, 850nm, MMF, 100m@OM3, 150m@OM4, MTP/MPO, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/QSFP28-SR4-100G.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/39025.html" target="_blank">Standard 100G QSFP28</a></td>
				  <td><a href="/products/39025.html" target="_blank">QSFP28-LR4-100G</a></td>
				  <td>QSFP28, 100GBase-LR4, 1310nm, SMF, 10km, LC, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/QSFP28-LR4-100G.pdf" target="_blank" class="download">download</a></td>
				</tr>
			</table>

				</div>
			  </div>
			</div>
		  </div>
		</div>';
	}else if(in_array($pid,array(48862,48863))){
		$html .= '<div class="open-close-section">
		  <div class="open-close filter-item"> 
			<div class="opener-holder opener ">Juniper Networks 100G QSFP28 Transceivers Series</div>
			<div class="slide" >
			  <div class="sub-open-close">
				<div class="sub-slide">
				  <table cellspacing="0" cellpadding="0">
				<tr>
				  <th>Aplication</th>
				  <th align="center">Part Number</th>
				  <th>Description</th>
				  <th>&nbsp;</th>
				</tr>
				<tr>
				  <td><a href="/products/48862.html" target="_blank">Standard 100G QSFP28</a></td>
				  <td><a href="/products/48862.html" target="_blank">JNP-QSFP-100G-SR4</a></td>
				  <td>QSFP28, 100GBase-SR4, 850nm, MMF, 100m@OM3, 150m@OM4, MTP/MPO, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/JNP-QSFP-100G-SR4.pdf" target="_blank" class="download">download</a></td>
				</tr>
				<tr>
				  <td><a href="/products/48863.html" target="_blank">Standard 100G QSFP28</a></td>
				  <td><a href="/products/48863.html" target="_blank">JNP-QSFP-100G-LR4</a></td>
				  <td>QSFP28, 100GBase-LR4, 1310nm, SMF, 10km, LC, DOM</td>
				  <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/JNP-QSFP-100G-LR4.pdf" target="_blank" class="download">download</a></td>
				</tr>
			</table>

				</div>
			  </div>
			</div>
		  </div>
		</div>';
	}else{
		$html = '';
	}
	return $html;
}

function fs_html_of_10g_BPDF($pid){
    if(in_array($pid,array(48803,36984,36983,36985,48805,36986,36981,48804))){
		$html = '<div class="open-close-section">
      <div class="open-close filter-item"> 
        <div class="opener-holder opener ">Arista Networks Standard 10G SFP+ Transceivers Series</div>
        <div class="slide" >
          <div class="sub-open-close">
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0">
            <tr>
              <th>Aplication</th>
              <th align="center">Part Number</th>
              <th>Description</th>
              <th>&nbsp;</th>
            </tr>
            <tr>
              <td><a href="/products/36982.html" target="_blank">Standard 10G SFP+</a></td>
              <td><a href="/products/36982.html" target="_blank">SFP-10G-SR </a></td>
              <td>SFP+, 10GBase-SR, 850nm, MMF, 300m@OM3, LC, DOM</td>
              <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/SFP-10G-SR.pdf" target="_blank" class="download">download</a></td>
            </tr>
            <tr>
              <td><a href="/products/48803.html" target="_blank">Standard 10G SFP+</a></td>
              <td><a href="/products/48803.html" target="_blank">SFP-10G-LRM</a></td>
              <td>SFP+, 10GBase-LRM, 1310nm, MMF, 220m, LC, DOM</td>
              <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/SFP-10G-LRM.pdf" target="_blank" class="download">download</a></td>
            </tr>
            <tr>
              <td><a href="/products/36983.html" target="_blank">Standard 10G SFP+</a></td>
              <td><a href="/products/36983.html" target="_blank">SFP-10G-LR</a></td>
              <td>SFP+, 10GBase-LR, 1310nm, SMF, 10km, LC, DOM</td>
              <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/SFP-10G-LR.pdf" target="_blank" class="download">download</a></td>
            </tr>
            <tr>
              <td><a href="/products/36985.html" target="_blank">Standard 10G SFP+</a></td>
              <td><a href="/products/36985.html" target="_blank">SFP-10G-ER</a></td>
              <td>SFP+, 10GBase-ER, 1550nm, SMF, 40km, LC, DOM</td>
              <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/SFP-10G-ER.pdf" target="_blank" class="download">download</a></td>
            </tr>
            <tr>
              <td><a href="/products/36986.html" target="_blank">Standard 10G SFP+</a></td>
              <td><a href="/products/36986.html" target="_blank">SFP-10G-ZR</a></td>
              <td>SFP+, 10GBase-ZR, 1550nm, SMF, 80km, LC, DOM </td>
              <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/SFP-10G-ZR.pdf" target="_blank" class="download">download</a></td>
            </tr>
            <tr>
              <td><a href="/products/48805.html" target="_blank">Standard 10G SFP+</a></td>
              <td><a href="/products/48805.html" target="_blank">SFP-10G-ZR100</a></td>
              <td>SFP+, 10GBase-ZR, 1550nm, SMF, 100km, LC, DOM </td>
              <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/SFP-10G-ZR100.pdf" target="_blank" class="download">download</a></td>
            </tr> 
        </table>
            </div>
          </div>
        </div>
      </div>
    </div>';
	}else if(in_array($pid,array(31443,31441,48809,31375,48810,31381,48811,39549,39603,31376,31382))){
	$html = '<div class="open-close-section">
      <div class="open-close filter-item"> 
        <div class="opener-holder opener ">Brocade Standard 10G SFP+ Transceivers Series</div>
        <div class="slide" >
          <div class="sub-open-close">
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0">
            <tr>
              <th>Aplication</th>
              <th align="center">Part Number</th>
              <th>Description</th>
              <th>&nbsp;</th>
            </tr>
            <tr>
              <td><a href="/products/31443.html" target="_blank">Standard 10G SFP+</a></td>
              <td><a href="/products/31443.html" target="_blank">10G-SFPP-SR</a></td>
              <td>SFP+, 10GBase-SR, 850nm, MMF, 300m@OM3, LC, DOM</td>
              <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/10G-SFPP-SR.pdf" target="_blank" class="download">download</a></td>
            </tr>
            <tr>
              <td><a href="/products/31441.html" target="_blank">Standard 10G SFP+</a></td>
              <td><a href="/products/31441.html" target="_blank">10G-SFPP-LRM</a></td>
              <td>SFP+, 10GBase-LRM, 1310nm, MMF, 220m, LC, DOM</td>
              <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/10G-SFPP-LRM.pdf" target="_blank" class="download">download</a></td>
            </tr>
            <tr>
              <td><a href="/products/31375.html" target="_blank">Standard 10G SFP+</a></td>
              <td><a href="/products/31375.html" target="_blank">10G-SFPP-LR</a></td>
              <td>SFP+, 10GBase-LR, 1310nm, SMF, 10km, LC, DOM</td>
              <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/10G-SFPP-LR.pdf" target="_blank" class="download">download</a></td>
            </tr>
            <tr>
              <td><a href="/products/31381.html" target="_blank">Standard 10G SFP+</a></td>
              <td><a href="/products/31381.html" target="_blank">10G-SFPP-ER</a></td>
              <td>SFP+, 10GBase-ER, 1550nm, SMF, 40km, LC, DOM</td>
              <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/10G-SFPP-ER.pdf" target="_blank" class="download">download</a></td>
            </tr>
            <tr>
              <td><a href="/products/31382.html" target="_blank">Standard 10G SFP+</a></td>
              <td><a href="/products/31382.html" target="_blank">10G-SFPP-ZR</a></td>
              <td>SFP+, 10GBase-ZR, 1550nm, SMF, 80km, LC, DOM </td>
              <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/10G-SFPP-ZR.pdf" target="_blank" class="download">download</a></td>
            </tr>
            <tr>
              <td><a href="/products/48811.html" target="_blank">Standard 10G SFP+</a></td>
              <td><a href="/products/48811.html" target="_blank">10G-SFPP-ZR100</a></td>
              <td>SFP+, 10GBase-ZR, 1550nm, SMF, 100km, LC, DOM </td>
              <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/SFP-10G-ZR100.pdf" target="_blank" class="download">download</a></td>
            </tr> 
        </table>
            </div>
          </div>
        </div>
      </div>';
	}else if(in_array($pid,array(11556,48812,11555,11557,48814,36436,11558,21146,36433,21171,36434,36435,48813,15245,15375,15377,
	39381,39382,39385,39380,39384,39383,39294,39295))){ //cisco
	$html='    <div class="open-close-section">
      <div class="open-close filter-item"> 
        <div class="opener-holder opener ">Cisco Standard 10G SFP+ Transceivers Series</div>
        <div class="slide" >
          <div class="sub-open-close">
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0">
            <tr>
              <th>Aplication</th>
              <th align="center">Part Number</th>
              <th>Description</th>
              <th>&nbsp;</th>
            </tr>
            <tr>
              <td><a href="/products/11552.html" target="_blank">Standard 10G SFP+</a></td>
              <td><a href="/products/11552.html" target="_blank">SFP-10G-SR</a></td>
              <td>SFP+, 10GBase-SR, 850nm, MMF, 300m@OM3, LC, DOM</td>
              <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/SFP-10G-SR.pdf" target="_blank" class="download">download</a></td>
            </tr>
            <tr>
              <td><a href="/products/11556.html" target="_blank">Standard 10G SFP+</a></td>
              <td><a href="/products/11556.html" target="_blank">SFP-10G-LRM</a></td>
              <td>SFP+, 10GBase-LRM, 1310nm, MMF, 220m, LC, DOM</td>
              <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/SFP-10G-LRM.pdf" target="_blank" class="download">download</a></td>
            </tr>
            <tr>
              <td><a href="/products/11555.html" target="_blank">Standard 10G SFP+</a></td>
              <td><a href="/products/11555.html" target="_blank">SFP-10G-LR</a></td>
              <td>SFP+, 10GBase-LR, 1310nm, SMF, 10km, LC, DOM</td>
              <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/SFP-10G-LR.pdf" target="_blank" class="download">download</a></td>
            </tr>
            <tr>
              <td><a href="/products/11557.html" target="_blank">Standard 10G SFP+</a></td>
              <td><a href="/products/11557.html" target="_blank">SFP-10G-ER</a></td>
              <td>SFP+, 10GBase-ER, 1550nm, SMF, 40km, LC, DOM</td>
              <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/SFP-10G-ER.pdf" target="_blank" class="download">download</a></td>
            </tr>
            <tr>
              <td><a href="/products/11558.html" target="_blank">Standard 10G SFP+</a></td>
              <td><a href="/products/11558.html" target="_blank">SFP-10G-ZR</a></td>
              <td>SFP+, 10GBase-ZR, 1550nm, SMF, 80km, LC, DOM </td>
              <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/SFP-10G-ZR.pdf" target="_blank" class="download">download</a></td>
            </tr>
            <tr>
              <td><a href="/products/48814.html" target="_blank">Standard 10G SFP+</a></td>
              <td><a href="/products/48814.html" target="_blank">SFP-10G-ZR100</a></td>
              <td>SFP+, 10GBase-ZR, 1550nm, SMF, 100km, LC, DOM </td>
              <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/SFP-10G-ZR100.pdf" target="_blank" class="download">download</a></td>
            </tr>
        </table>

            </div>
          </div>
        </div>
      </div>
    </div>';
	}else if(in_array($pid,array(58773,58774,39806,11590,29795,29901,11595,11592,29799,11591,29797,29899,11589)) ){   //Generic
	$html='    <div class="open-close-section">
      <div class="open-close filter-item"> 
        <div class="opener-holder opener ">Generic standard 10G SFP+ Transceivers Series</div>
        <div class="slide" >
          <div class="sub-open-close">
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0">
            <tr>
              <th>Aplication</th>
              <th align="center">Part Number</th>
              <th>Description</th>
              <th>&nbsp;</th>
            </tr>
            <tr>
              <td><a href="/products/11589.html" target="_blank">Standard 10G SFP+</a></td>
              <td><a href="/products/11589.html" target="_blank">SFP-10GSR-85</a></td>
              <td>SFP+, 10GBase-SR, 850nm, MMF, 300m@OM3, LC, DOM</td>
              <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/SFP-10GSR-85.pdf" target="_blank" class="download">download</a></td>
            </tr>
            <tr>
              <td><a href="/products/11590.html" target="_blank">Standard 10G SFP+</a></td>
              <td><a href="/products/11590.html" target="_blank">SFP-10GLRM-31 </a></td>
              <td>SFP+, 10GBase-LRM, 1310nm, MMF, 220m, LC, DOM</td>
              <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/SFP-10GLRM-31.pdf" target="_blank" class="download">download</a></td>
            </tr>
            <tr>
              <td><a href="/products/11591.html" target="_blank">Standard 10G SFP+</a></td>
              <td><a href="/products/11591.html" target="_blank">SFP-10GLR-31</a></td>
              <td>SFP+, 10GBase-LR, 1310nm, SMF, 10km, LC, DOM</td>
              <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/SFP-10GLR-31.pdf" target="_blank" class="download">download</a></td>
            </tr>
            <tr>
              <td><a href="/products/11592.html" target="_blank">Standard 10G SFP+</a></td>
              <td><a href="/products/11592.html" target="_blank">SFP-10GER-55</a></td>
              <td>SFP+, 10GBase-ER, 1550nm, SMF, 40km, LC, DOM</td>
              <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/SFP-10GER-55.pdf" target="_blank" class="download">download</a></td>
            </tr>
            <tr>
              <td><a href="/products/11595.html" target="_blank">Standard 10G SFP+</a></td>
              <td><a href="/products/11595.html" target="_blank">SFP-10GZR-55</a></td>
              <td>SFP+, 10GBase-ZR, 1550nm, SMF, 80km, LC, DOM </td>
              <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/SFP-10GZR-55.pdf" target="_blank" class="download">download</a></td>
            </tr>
            <tr>
              <td><a href="/products/29799.html" target="_blank">Standard 10G SFP+</a></td>
              <td><a href="/products/29799.html" target="_blank">SFP-10GZRC-55</a></td>
              <td>SFP+, 10GBase-ZR, 1550nm, SMF, 100km, LC, DOM </td>
              <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/SFP-10GZRC-55.pdf" target="_blank" class="download">download</a></td>
            </tr>
            <tr>
              <td><a href="/products/29899.html" target="_blank">1G/10G SFP+</a></td>
              <td><a href="/products/29899.html" target="_blank">SFP-10GSR-85 </a></td>
              <td>SFP+, 10GBASE-SR and 1000BASE-SX, 850nm, MMF, 550m@1.25Gbps,300m@10.3Gbps, LC, DOM</td>
              <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/SFP-10GSR-85.pdf" target="_blank" class="download">download</a></td>
            </tr>
            <tr>
              <td><a href="/products/29901.html" target="_blank">1G/10G SFP+</a></td>
              <td><a href="/products/29901.html" target="_blank">SFP-10GLR-31</a></td>
              <td>SFP+, 10GBASE-LR and 1000BASE-LX, 1310nm, SMF, 20km@1.25Gbps,10km@10.3Gbps, LC, DOM </td>
              <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/SFP-10GLR-31.pdf" target="_blank" class="download">download</a></td>
            </tr>
        </table>
            </div>
          </div>
        </div>
      </div>
    </div>';
	}else if(in_array($pid,array(31287,11571,48836,11581,15451,48838,39596,39620,39595,39619,58800,58801,15453,15454,48837,11582,
	31374,15441,15446)) ){      //juniper
	$html ='<div class="open-close-section">
      <div class="open-close filter-item"> 
        <div class="opener-holder opener "> Juniper Networks Standard 10G SFP+ Transceivers Series</div>
        <div class="slide" >
          <div class="sub-open-close">
            <div class="sub-slide">
              <table cellspacing="0" cellpadding="0">
            <tr>
              <th>Aplication</th>
              <th align="center">Part Number</th>
              <th>Description</th>
              <th>&nbsp;</th>
            </tr>
            <tr>
              <td><a href="/products/31287.html" target="_blank">Standard 10G SFP+</a></td>
              <td><a href="/products/31287.html" target="_blank">EX-SFP-10GE-SR</a></td>
              <td>SFP+, 10GBase-SR, 850nm, MMF, 300m@OM3, LC, DOM</td>
              <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/EX-SFP-10GE-SR.pdf" target="_blank" class="download">download</a></td>
            </tr>
            <tr>
              <td><a href="/products/11571.html" target="_blank">Standard 10G SFP+</a></td>
              <td><a href="/products/11571.html" target="_blank">EX-SFP-10GE-LRM</a></td>
              <td>SFP+, 10GBase-LRM, 1310nm, MMF, 220m, LC, DOM</td>
              <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/EX-SFP-10GE-LRM.pdf" target="_blank" class="download">download</a></td>
            </tr>
            <tr>
              <td><a href="/products/11581.html" target="_blank">Standard 10G SFP+</a></td>
              <td><a href="/products/11581.html" target="_blank">EX-SFP-10GE-LR</a></td>
              <td>SFP+, 10GBase-LR, 1310nm, SMF, 10km, LC, DOM</td>
              <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/EX-SFP-10GE-LR.pdf" class="download">download</a></td>
            </tr>
            <tr>
              <td><a href="/products/11582.html" target="_blank">Standard 10G SFP+</a></td>
              <td><a href="/products/11582.html" target="_blank">EX-SFP-10GE-ER</a></td>
              <td>SFP+, 10GBase-ER, 1550nm, SMF, 40km, LC, DOM</td>
              <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/EX-SFP-10GE-ER.pdf" target="_blank" target="_blank" class="download">download</a></td>
            </tr>
            <tr>
              <td><a href="/products/15454.html" target="_blank">Standard 10G SFP+</a></td>
              <td><a href="/products/15454.html" target="_blank">EX-SFP-10GE-ZR</a></td>
              <td>SFP+, 10GBase-ZR, 1550nm, SMF, 80km, LC, DOM </td>
              <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/EX-SFP-10GE-ZR.pdf" target="_blank" target="_blank" class="download">download</a></td>
            </tr>
            <tr>
              <td><a href="/products/48838.html" target="_blank">Standard 10G SFP+</a></td>
              <td><a href="/products/48838.html" target="_blank">EX-SFP-10GE-ZR100</a></td>
              <td>SFP+, 10GBase-ZR, 1550nm, SMF, 100km, LC, DOM </td>
              <td ><a href="'.HTTPS_IMAGE_SERVER.'images/PDF/SFP-10G-ZR100.pdf" target="_blank" class="download">download</a></td>
            </tr> 
        </table>
            </div>
          </div>
        </div>
      </div>
    </div>';
	}
	return $html;
}

/**
 * @param int $pid
 * @return bool
 * 判断是否打折
 */
function is_discount($pid = 0)
{
    global $db;
    if (isset($_SESSION['member_level'])) {
        $pid = (int)$pid;
        if (empty($pid)) {
            return false;
        }
        //ternence 判断是否享受企业会员折扣
        $corporate_discount = fs_get_data_from_db_fields("corporate_discount", TABLE_PRODUCTS, "products_id = {$pid} LIMIT 1");
        if($corporate_discount==0){
            return false;
        }
        return true;
    }
    return false;
}
?>