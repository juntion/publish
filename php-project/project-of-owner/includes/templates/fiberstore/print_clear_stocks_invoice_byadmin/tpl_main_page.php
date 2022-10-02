<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<style type="text/css">
body{margin:0 auto; padding:0; font-size:11px; font-family:Arial, Helvetica, sans-serif; color:#232323; -webkit-text-size-adjust:none; background:#fff; line-height:20px}
h2{ margin:0; padding:0;}
.receipt{width:960px;font-size: 10px;line-height:16px;margin: 0px auto;}
.receipt_table { border-left:1px solid #616265;}
.receipt_table tr th{ background:#616265; text-align:left; line-height:16px;padding:5px; color:#fff;}
.receipt_table tr td{ padding:5px; border-bottom:1px solid #616265 ; border-right:1px solid #616265;}
.receipt_table tr td i{ color:#999; font-style:normal;}
.receipt_table tr td .receipt_kuang{ border:1px solid #cccccc; width:12px; height:12px; display:inline-block;}
.receipt_tit h2{ font-size:24px;text-align:center; padding:10px 0 0 0; display:block;}
.receipt_tit span{ display:block; font-size:11px; padding:15px 0 10px 0;}
.tax_color{ color:#a10000;}
</style>
</head>


<?php
$instock = $db->Execute("select * from  products_instock_shipping  where products_instock_id = ".$_GET['s']);

$db->Execute("update products_instock_shipping set print_invoice = 1 where products_instock_id ='".$_GET['s']."' ");

$list = $db->getAll("select * from products_instock_shipping_info  where products_instock_id = ".$_GET['s']);

 $sales_admin_info = $db->getAll("SELECT `admin_name` FROM `admin` WHERE `admin_id`=".$instock->fields['sales_admin']);
 $sales_admin=$sales_admin_info[0]['admin_name'] ? $sales_admin_info[0]['admin_name'] : '--' ;
 $sales_assistant_info = $db->getAll("SELECT `admin_name` FROM `admin` WHERE `admin_id`=". $instock->fields['sales_assistant']);
 $sales_assistant=$sales_assistant_info[0]['admin_name'] ? $sales_assistant_info[0]['admin_name'] : '--' ;  
 
 $orders_id=$instock->fields['orders_id'];
 
 
 
?>

 

<body>
<div class="receipt">
<div class="receipt_tit"><h2>订货单</h2><span>录入时间：<?php echo $instock->fields['finance_time']; ?>&nbsp;&nbsp;&nbsp;&nbsp;
发票号/编号：<?php echo $instock->fields['order_number'] ? $instock->fields['order_number'] : $instock->fields['order_invoice']; ?> / <?php echo $instock->fields['orders_num']; ?>  &nbsp;&nbsp;&nbsp;&nbsp;
国家/运输：<?php echo zen_get_order_product_of_countries($orders_id) ? zen_get_order_product_of_countries($orders_id) : zen_get_order_product_of_unline_countries($instock->fields['products_instock_id']);?>
 / <?php echo zen_get_order_product_of_shipping_method($orders_id) ? strtoupper(str_replace('zones','',zen_get_order_product_of_shipping_method($orders_id))) : zen_get_order_product_of_shipping_unline_method($instock->fields['products_instock_id']);?>
 &nbsp;&nbsp;&nbsp;&nbsp;
 业务/助理:<?php echo $sales_admin; ?> / <?php echo $sales_assistant; ?> </span></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="receipt_table">
 <tr>
   <th width="">产品名称</th>
    <th width="4%">数量</th>
    <th width="20%">特性备注</th>
    <th width="12%">装箱单标签</th>
    <th width="6%">付款方式</th>
    <th width="5%">备货区</th>
    
    <th width="6%">采购员</th>
    <th width="6%">检验员</th>
    <th width="6%">发货助理</th>
    <th width="6%">物流员</th>
    </tr>
  
<?php if($list){ ?>
  <?php foreach($list as $key=>$v){
  
 $products_attributes = 0; 

 $products_id = $v['products_id'];
  if($products_id){
	$products_image = zen_get_products_image_of_products_id($products_id);
	$products_name = $v['products_name'] ? $v['products_name'] : zen_get_products_name($products_id) ;
	if(isset($orders_id) && $v['orders_products_id']){
		$products_attributes = zen_get_order_product_attributes_by_order_products($orders_id,$v['orders_products_id']);
		$products_length = zen_get_order_product_length_by_order_products($orders_id,$v['orders_products_id']);
	}
  }  
  ?>

  <tr>
    <td><?php echo $products_name;?><br />
      型号名:<?php echo   $v['products_model'] ? $v['products_model'] : zen_get_order_product_of_model($products_id);?><br />
      序列号：<?php echo $v['products_first_serial_num']."-".$v['products_last_serial_num'];?><br />
	  <?php
      if(isset($products_length) && sizeof($products_length)){
                               for($pl=0;$pl<sizeof($products_length);$pl++){
                                echo '<i>Length: '.$products_length[$pl]['length_name'].'</i><br>';
                               }
                              }
                if(isset($products_attributes) && sizeof($products_attributes)){
	                            for($rr=0;$rr<sizeof($products_attributes);$rr++){
	                              if ($products_attributes[$rr]['price'] != '0.00'){
	                              $attributes_price = '&nbsp;&nbsp;'.$products_attributes[$rr]['prefix'].$products_attributes[$rr]['price'];
	                              }
	                              echo '<i>'.$products_attributes[$rr]['options'].' - '.$products_attributes[$rr]['values'].$attributes_price.'</i><br>';
	                            }
            }
	 ?>
    </td>  
    <td><?php echo $v['products_num'];?></td>
    
     <td class="tax_color"><?php echo $v['products_tag'];?></td>
    
      <td><?php echo $v['products_message']; ?><br />
                附件：
      </td>
    
      <td>
		<?php 												
		 $order_payment_status = $instock->fields['order_payment'];
		 switch($order_payment_status){
			 case '1':
				 $order_payment = 'Credit card(975)';
			     break;
			 case '2':
				 $order_payment = 'Paypal';
			    break;
			 case '3':
				 $order_payment = 'Bank Transfer';
			    break;
			 case '4':
				 $order_payment = 'Net 30';
			    break;
			 case '5':
				 $order_payment = '未付款,先备货';
			     break;
			 case '6':
				 $order_payment = 'Credit card(800)';
			     break;
		 }
		 echo $order_payment;
		 ?>
	</td>      
          
    <td><?php echo zen_get_order_product_of_bzone($v['products_instock_id']);?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>   
     <?php } ?>
  <?php } ?>
  
</table>
</div>
</body>
<script type="text/javascript">
window.print();</script>
</html>
