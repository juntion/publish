<div id='basic-modal'><input type="hidden" name="cart_quantitys" id="cart_quantitys" value=1>
<span id="shipping_result" class="shipping_info">
<?php 
$us_states = zen_get_countries_us_states();
if($product_info->fields['product_is_free']== 1){ ?>
	<font color='text_color_05'><?php echo FS_FREE_SHIP;?></font>
<?php  
}else{
	foreach($shipping as $key=>$v){
	$result = $db->getAll("select countries_name from countries where countries_iso_code_2 = '$countries_code_2' limit 1");
	$countries_name = $result[0]['countries_name'];
	$countries_name = !empty($countries_name) ? $countries_name : "United States";
	?>
		<?php if(isset($v['methods'][0]['cost'])){
		$v['methods'][0]['cost'] = sprintf('%.2f',$v['methods'][0]['cost']);
				?>
						<?php if(($v['methods'][0]['cost']) == 0){ ?>
								<?php if($v['methods'][0]['id'] == 'customzones'){  ?>
										<b><font><?php echo $currencies->new_format($v['methods'][0]['cost']); ?></font></b> <?php echo FS_TO;?> <a href="javascript:void(apps())" onclick="app()"><?php echo $countries_name;?> <?php echo FS_VIA;?> <?php echo $v['ids']; ?></a>
								<?php  }else{  ?>
										    <?php if($countries_code_2 == 'US'){ ?>
														<font class="text_color_05"><?php echo FS_FREE_SHIP;?></font><font>&nbsp;&nbsp;<?php echo $v['ids']; ?></font>&nbsp;Service <i class="shipping_service">|</i>  <a href="javascript:void(apps())" onclick="app()" class="see_detail">See details</a>
											<?php }else{ ?>
											<font class="text_color_05"><?php echo FS_FREE_SHIP;?></font>  <?php echo FS_TO;?> <a href="javascript:void(apps())" onclick="app()" ><font><?php echo $countries_name;?> <?php echo FS_VIA;?> <?php echo $v['ids']; ?></font></a>
											<?php } ?>
								<?php  }  ?>
	     		
	     		<?php }else{ ?>  		
				
									<?php if($countries_code_2 == 'US'){ ?>
														<font class="text_color_05"><?php echo $currencies->new_format($v['methods'][0]['cost']); ?></font><font>&nbsp;&nbsp;<?php echo $v['ids']; ?></font>&nbsp;Service <i class="shipping_service">|</i> <a href="javascript:void(apps())" onclick="app()" class="see_detail">See details</a>
											<?php }else{ ?>
												<b><font><?php echo $currencies->new_format($v['methods'][0]['cost']); ?></font></b> <?php echo FS_TO;?> <a href="javascript:void(apps())" onclick="app()"><?php echo $countries_name;?> <?php echo FS_VIA;?> <?php echo $v['ids']; ?></a>
											<?php } ?>


	    		
	     		<?php } ?>
	      <?php break;
			} ?>
	 <?php } ?>
<?php } ?>
</span>

</div>

<div style="display: none;" id="fs_overlays" class="ui-overlay"><div style="filter: alpha(opacity=30);" class="ui-widget-overlay"></div>
<div id="basic-modal-content" class="ui-widget ui-widget-content ui-corner-all ui-corner-layer ui-corner-fixed"  >
<div class="popup_con">
	<?php //echo get_shipping_method_html($countries,$shipping,$countries_code_2);?>
		<div id="modal-content1">
			<ul  class="regist_width shipping_countries">
				<li class="regist_country_01">
				<span><?php echo FS_SHIP_ORDER;?></span>  <div class="shipping_countries_us">
                          <?php 
                          echo zen_draw_countries_pull_down_add_tag_shipping('customer_country_id',' id="curCountry1"  class="login_country"',223,$countries_name,$countries_code_2);
                  ?>      
		 <?php   

		 if(zen_get_instock_products_warehouse_ny($_GET['products_id']) && $countries_code_2=='US'){  
					  $style="";
				     }else{
						  $style="style='display:none'";
					 }
				   ?>
							
									<!-- <select id="states" name="states" class="login_country" onchange="get_infomatons()" <?php echo $style;?>>
										   <?php foreach($us_states as $key=>$v){ ?>
												<option value="<?php echo $v['states_code'];?>"><?php echo $v['states'];?></option>
											<?php } ?>
									</select> -->
	<div class="post_code" id="postcodes" <?php echo $style;?>><input id="postcode" name="postcode"   class="big_input" type="text"><p class="post_code_prompt" style="display: block;">Postal Code</p><button type='button' class="button_11" onclick = "get_infomatons()">Get Rates</button></div></div>
			<?php	 
				   ?>
                   </li>
			</ul>
		</div>
		<div id="modal-content2" class="shipping_countries_font">
		<?php echo FS_CHOOSE_SHIP;?>
		</div>
		<div id="modal-content3" class="shipping_countries_y">
				<?php echo get_shipping_method_html($countries,$shipping,$countries_code_2,$_GET['products_id'],'');?>
		</div>
		<div class="padding_top10"><input  type="button" onclick="return my_submit();" value="Confirm" class="button_02 bbb"></div>
	<div class="box_close"><a href="javascript: ;" onclick="$('#fs_overlays,.ui-widget-overlay,#basic-modal-content').hide();"></a></div>
</div>
</div>
</div>

<script type="text/javascript">


$('#postcode').focus(function(){
		$('.post_code_prompt').hide();
	})
	$('#postcode').blur(function(){
		if($(this).val()==""){
			$('.post_code_prompt').show();
		}
	})

	$('.post_code_prompt').click(function(){
		$('.post_code_prompt').hide();
		$('#postcode').focus();
	})

	function apps(){
		$('#fs_overlays,.ui-widget-overlay,#basic-modal-content').show();
		$("body").css({"overflow":"hidden","overflow-y":"hidden"});
		$('body').bind('touchmove', function(event) {
	        //判断条件,条件成立才阻止背景页面滚动,其他情况不会再影响到页面滚动
	        if(!$("body").is(":hidden")){
	            event.preventDefault();
	        }
	    })
	}

	function enjoy(){
		$('#share,#basic_share').show();
		$("body").css({"overflow":"hidden","overflow-y":"hidden"});
		$('body').bind('touchmove', function(event) {
	        //判断条件,条件成立才阻止背景页面滚动,其他情况不会再影响到页面滚动
	        if(!$("body").is(":hidden")){
	            event.preventDefault();
	        }
	    })
		
	}
	
	function get_infomaton(countries_code_2){
		if(countries_code_2 != 'US'){
			//$("#states").hide();
			$("#postcodes").hide();
		}else{
			//$("#states").show();
			$("#postcodes").show();
		}
		
		try{
		   var length = $("#length_attribute").val();
		}
		catch(e){
			
			var length = 0;	   
		}
		
		try{
		    var custom_length = $("#custom_length").val();
		}
		catch(e){
			
			var custom_length = 0;	   
		}
		try{
		   var fiber_count = $("#fiber_count option:selected").text();
		   var fiber_count = Number(fiber_count.replace(/Fibers/g, ''));
		}
		catch(e){
			
			var fiber_count = 0;	   
		}
try{
		   var postcode = $("#postcode").val();
		}
		catch(e){
			
			var postcode = 0;	   
		}
		var states = 0;
		var products_id = <?php echo $_GET['products_id'];?>
		//var thisURL = document.URL;
		thisURL = "index.php?main_page=shipping_infomation";
		thisURL += "&type=1";
		$.ajax({
            type: "POST",
            dataType: "html",
            url: thisURL,
             data:"countries_code_2="+countries_code_2+"&products_id="+products_id+"&cart_quantity="+$("input[name='cart_quantity']").val()+"&states="+states+"&length="+length+"&custom_length="+custom_length+"&fiber_count="+fiber_count+"&postcode="+postcode,
            success: function(msg){
                $("#modal-content3").html(msg);
            }   
        });
	}
	function get_infomatons(){
		if(typeof($("#states").val()) != "undefined"){
			var states = $("#states").val();
		}else{
			var states = 0;
		}
		try{
		   var postcode = $("#postcode").val();
		}
		catch(e){
			
			var postcode = 0;	   
		}
		try{
			   var length = $("#length_attribute").val();
			}
			catch(e){
				
				var length = 0;	   
			}
			
			try{
			    var custom_length = $("#custom_length").val();
			}
			catch(e){
				
				var custom_length = 0;	   
			}
			try{
			    var countries_code_2 = $("#countries_iso_code_2").val();
			}
			catch(e){
				
				var countries_code_2 = 'US';  
			}
		var products_id = <?php echo $_GET['products_id'];?>
		//var thisURL = document.URL;
		thisURL = "index.php?main_page=shipping_infomation";
		thisURL += "&type=1";
		$.ajax({
            type: "POST",
            dataType: "html",
            url: thisURL,
            data:"countries_code_2="+countries_code_2+"&products_id="+products_id+"&cart_quantity="+$("input[name='cart_quantity']").val()+"&states="+states+"&length="+length+"&custom_length="+custom_length+"&postcode="+postcode,
            success: function(msg){
               // $("#basic-modal-content").html(msg);
			   $("#modal-content3").html(msg);
            }   
        });
	}
	function delHtmlTag(str)
	{
	return str.replace(/<[^>]+>/g,"");
	}
	function my_submit(){
		var shipping_methods = delHtmlTag($("input[name='choice']:checked").val());
		if(shipping_methods.indexOf('Collect')>=0){
			if(!$('#acount').val()){
				$('#acount').siblings('.help_info').removeClass('yes').addClass('no');
				return false;
			}else{
				$('#acount').siblings('.help_info').removeClass('no');
			}
		}else{
			$('#acount').siblings('.help_info').removeClass('no');
		}
		var countries_code_2 = $("#countries_code_2 option:selected").text();
		var method = $("#method").val();
		var acount = $("#acount").val();
		if($("input[name='choice']:checked").val()){
			var Cts = $("input[name='choice']:checked").val();
				$("#shipping_result").html(($("input[name='choice']:checked").val()).replace('Country.php',countries_code_2));
		}
		//$.modal.impl.close();.replace('country',countries_code_2)
		$('#fs_overlays,.ui-widget-overlay,#basic-modal-content').css('display','none');
		thisURL = "index.php?main_page=shipping_infomation";
		thisURL += "&type=my_submit";
		$.ajax({
            type: "POST",
            dataType: "html",
            url: thisURL,
            data:"choice="+$("input[name='choice']:checked").val()+"&method="+method+"&acount="+acount,
            success: function(msg){
            }   
        });
	}
	function app(){
		//if($("input[name='cart_quantity']").val() != 1){
			try{
			    var length = $("#length_attribute").val();
			}
			catch(e){
				
				var length = 0;	   
			}
			try{
			    var custom_length = $("#custom_length").val();
			}
			catch(e){
				
				var custom_length = 0;	   
			}
			try{
					var fiber_count = $("#fiber_count option:selected").text();
					var fiber_count = Number(fiber_count.replace(/Fibers/g, ''));
			}
			catch(e){
			
					var fiber_count = 0;	   
			}

			try{
			    var countries_code_2 = $("#countries_iso_code_2").val();
			}
			catch(e){
				
				var countries_code_2 = 'US';  
			}
	
			var products_id = "<?php echo $_GET['products_id'];?>";
			//var thisURL = document.URL;
			thisURL = "index.php?main_page=shipping_infomation";
			thisURL += "&type=1&act=2";
			$.ajax({
	            type: "POST",
	            dataType: "html",
	            url: thisURL,
	            data:"countries_code_2="+countries_code_2+"&products_id="+products_id+"&cart_quantity="+$("input[name='cart_quantity']").val()+"&length="+length+"&custom_length="+custom_length+"&fiber_count="+fiber_count,
	            success: function(msg){
	                $("#modal-content3").html(msg);
	            }   
	        });
			
		//}
	}
	function _act(){
		try{
		    var length = $("#length_attribute").val();

		}
		catch(e){

			var length = 0;
		}
		try{
		    var custom_length = $("#custom_length").val();
		}
		catch(e){

			var custom_length = 0;
		}
		try{
		   var fiber_count = $("#fiber_count option:selected").text();
		   var fiber_count = Number(fiber_count.replace(/Fibers/g, ''));
		}
		catch(e){

			var fiber_count = 0;
		}
		if(length>0){
			custom_length = 0;
		}
		try{
			    var countries_code_2 = $("#countries_iso_code_2").val();
			}
			catch(e){

				var countries_code_2 = 'US';
			}

		var products_id = <?php echo $_GET['products_id'];?>
		//var thisURL = document.URL;
		thisURL = "index.php?main_page=shipping_infomation";
		thisURL += "&type=1&act=1";
		$.ajax({
            type: "POST",
            dataType: "html",
            url: thisURL,
            data:"countries_code_2="+countries_code_2+"&products_id="+products_id+"&cart_quantity="+$("input[name='cart_quantity']").val()+"&length="+length+"&custom_length="+custom_length+"&fiber_count="+fiber_count,
            success: function(msg){
                $("#shipping_result").html(msg);
            }
        });
	}
	function _choice(i,a){
		var j = $("input[name='choice']");
		for(var h=1;h<=j.length;h++){
			if(h==i){
				j[i-1].checked = true;
				break;
			}
		}
		select_acount(a);
	}
	function select_acount(a){
		if(a == 'custom'){
			$("#shipping_method").show();
			$("#method").attr('disabled',false);
			$("#acount").attr('disabled',false);
		}else{
			$("#shipping_method").hide();
			$("#method").attr('disabled','disabled');
			$("#acount").attr('disabled','disabled');
		}
	}
	function products_wholesale_price(qty){
		var products_id = "<?php echo $_GET['products_id'];?>";
		$.ajax({
            type: "POST",
            dataType: "html",
            url: 'ajax_process_custom_shipping.php?request_type=wholesale_price',
            data:"qty="+qty+"&products_id="+products_id,
            success: function(msg){
				if(msg){
					$("#productsbaseprice").html(msg);
				}
            }   
        });

	}

	function get_products_instock_total_qty(country_code){
		var products_id = "<?php echo $_GET['products_id'];?>";
		$.ajax({
            type: "POST",
            dataType: "html",
            url: 'ajax_process_custom_shipping.php?request_type=products_instock',
            data:"products_id="+products_id+"&country_code="+country_code,
            success: function(msg){
				if(msg){
					$("#fs_availabilty").html(msg);
				}
            }   
        });

	}

	

	$(document).ready(function(){
		 
	//$("#productinfoBody").click(function(){
	$("body").click(function(){
			//$("#basic-modal-content").click(function(){
				//return false;
			//});
			if($("input[name='cart_quantity']").val() == $("#cart_quantitys").val()){
			}else{
				
				_act();
				//products_wholesale_price($("input[name='cart_quantity']").val());
				$("#cart_quantitys").val($("input[name='cart_quantity']").val());

			}
		});
		
	});
	
	$(function(){
//close box41 when mouse click event on document other elements
	var 
	country = $("input[name='country']").val();
	
	if(country > 0){alert(country);$('#s_tel_prefix').text(country_to_telephone[country]);}
	$(country).change(function(){
		c_id = $(this).val();
		if(c_id > 0){$('#s_tel_prefix').text(country_to_telephone[c_id]);}
	});
	

	$('#curCountry1 > span').click(function(){
		if('none' == $('#box41').css('display')){
			$('#box41').css('display','block');
		}else
			$('#box41').css('display','none');
	});
		
	
$('#curCountry1 > ul li > ul > li > a').click(function(){
	
	var str = $(this).attr('ctr').replace(/'/gi,"\"");
	var obj = JSON.parse(str);	
	var country_code = obj.change_to_country;	
	var country_name = $(this).text();
	if(country_code == 'us'){
		$("#fs_delivery").show();
	}else{
		$("#fs_delivery").hide();
	}
	if(country_code == 'us' || country_code == 'ca' || country_code == 'mx'){
		$("#item_loca").show();
	}else{
		$("#item_loca").hide();
	}
	var products_id = "<?php echo $_GET['products_id'];?>";
	//set country id to tag country
	$('input[name="countries_iso_code_2"]').val($(this).attr('tag'));
	get_infomaton($(this).attr('tag'));
	$('#curCountry1').find('#your_currency').html('<em class="flag ' + country_code + '"></em>'+country_name+'<span class="caret"></span>');
	$('#box41').hide();
	$('#s_tel_prefix').text(country_to_telephone[country_name]);
	get_products_instock_total_qty(country_code);
});

});
$('.box_close a').click(function(){
	$("body").css({"overflow":"","overflow-y":""});
    $("body").unbind("touchmove");
})
</script>
