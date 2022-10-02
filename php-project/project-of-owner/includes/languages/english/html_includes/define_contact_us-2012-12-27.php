<?php
/**
 * contact us

 */?>

 <script type="text/javascript">
$(function(){
var fields_arr = [['text','contactname',2],
	              ['email','email'],
	              ['confirmemail','confirmemail'],

	              ['textarea','enquiry',2]	
	              	              
	             ];
$("input[name='contactname']").blur(function(){$("input[name='contactname']").css('border','1px solid #CCC');$('#err_contactname').hide();});
$("input[name='email']").blur(function(){$("input[name='email']").css('border','1px solid #CCC');$('#err_email').hide();});
$("input[name='confirmemail']").blur(function(){$("input[name='confirmemail']").css('border','1px solid #CCC');$('#err_cemail').hide();});
$("input[textarea='enquiry']").blur(function(){$("textarea[name='enquiry']").css('border','1px solid #CCC');$('#err_enquiry').hide();});


$("#contactForm").submit(function(){
	for(var i = 0, n = fields_arr.length; i < n; i++){

		switch(fields_arr[i][0]){
			case 'text':
				var value = $("input[name='"+fields_arr[i][1]+"']").val();
				if('' == value || value.length < 3){
					$("input[name='"+fields_arr[i][1]+"']").css({'border':'1px solid #c50001'}).focus();
					return false;
				}
				break;
			case 'textarea':
				var value = $("textarea[name='"+fields_arr[i][1]+"']").val();
				if('' == value || value.length < 3){
					$("textarea[name='"+fields_arr[i][1]+"']").css('border','1px solid #c50001').focus();
					return false;
				}
				break;	
			case 'confirmemail':
				var patten = /^[a-z]+\@[a-z0-9]+\.[a-zA-Z]+$/;
				var value = $("input[name='"+fields_arr[i][1]+"']").val();
				if(!patten.test(value)){
					$("input[name='"+fields_arr[i][1]+"']").css('border','1px solid #c50001').focus();
					return false;
					}
				break;		
			case 'email':
				var patten = /^[a-z]+\@[a-z0-9]+\.[a-zA-Z]+$/;
				var value = $("input[name='"+fields_arr[i][1]+"']").val();
				if(!patten.test(value)){
					$("input[name='"+fields_arr[i][1]+"']").css('border','1px solid #c50001').focus();
					return false;
					}
				break;
		}
	
	
	}
	return true;
	
});
$("#checkbox_tk").click(function(){if($(this).is(":checked"))$(this).val(1);else $(this).val(0);});});
</script>
        <div class="help_page">  
        <?php if ($messageStack->size('contact')) $messageStack->output('contact');?>
            <div class="about_main_bt1">
            <h1>Contáctenos</h1>
            </div>
            <div class="about_main">
            <p>Creemos en la oportunidad de la atención al cliente, y hará todo lo posible para satisfacer a nuestros clientes. Estamos encantados de responder cualquier pregunta que usted pueda tener acerca de nuestra oferta de productos, su cuenta, o cualquier otro servicio. Puede comunicarse con nosotros por teléfono, correo electrónico o chat en vivo. Todas las solicitudes de cotización serán respondidas dentro de las 24 horas a más tardar.</p>
                            <div class="contact">
			   <span class="contact_01 contact_05">Teléfono/Fax:</span>
			   <p>Línea directa: 86-755-83003611<br />
                Fax: 86-755-83269395</p>
			   <span class="contact_02 contact_05">Dirección de correo electrónico</span>
               Ventas: <a href="mailto:sales@fiberstore.com">sales@fiberstore.com</a><br />
               Servicio de Soporte: <a href="mailto:service@fiberstore.com">service@fiberstore.com</a><br />
			   <span class="contact_03 contact_05">Dirección Corporativa:</span>
               <p>FIBERSTORE Co, Limited<br>
                  5-D Inteligent Tower, Fumin Rd.,<br>
                  Futian District, Shenzhen 518045, China</p>
			   <span class="contact_04 contact_05">Live Chat</span>
			<p>Haga clic aquí para <a rel="nofollow" href="javascript:void(0);" onclick="return live800.navigateToUrl('http://chat8.live800.com/live800/chatClient/chatbox.jsp?companyID=152062&amp;configID=124793&amp;jid=2522617319&amp;enterurl=http%3A%2F%2Fwww%2Efiberstore%2Ecom%2F&amp;timestamp=1333015627844&amp;pagereferrer=', 'chatbox152062', globalWindowAttribute);">chatear en directo</a>. <br>
			   El horario de atención es de 24/7 Soporte y Ventas.</p>
			   <!-- 
			   Click here for <a onclick="return live800.navigateToUrl('http://chat8.live800.com/live800/chatClient/chatbox.jsp?companyID=152062&configID=124793&jid=2522617319&enterurl=http%3A%2F%2Fwww%2Efiberstore%2Ecom%2F&timestamp=1333015627844&pagereferrer=', 'chatbox152062', globalWindowAttribute);" href="javascript:void(0);" rel="nofollow">Live Chat</a>. <br />
			   The hours of operation are 24/7 sales & support.<br />
			   -->
</div>
               <div class="contact_rigth">

<iframe width="400" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Intelligent+Tower+Business+Center&amp;aq=&amp;sll=22.524172,114.065128&amp;sspn=0.002626,0.005252&amp;ie=UTF8&amp;hq=Intelligent+Tower+Business+Center&amp;hnear=&amp;t=m&amp;cid=4906616647687437477&amp;ll=22.534122,114.067526&amp;spn=0.023783,0.034332&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe>

</div>
			  
			  <div class="ccc"></div>
             <div class="con_us_lxfs">
                <div class="con_us_lxfs_tu con_tu_ly"></div>
                <div class="con_us_lxfs_wen">
                    <span><?php ECHO FIBERSTORE_CONTACT_MESSAGE;?></span>
                    <?php ECHO FIBERSTORE_CONTACT_MARKED;?>
                </div>
				<div class="ccc"></div>
                <div class="con_us_ly_mian">
                <?php echo zen_draw_form('contactForm', zen_href_link(FILENAME_CONTACT_US,'&action=send&securityToken='.$_SESSION['securityToken']),'POST','id="contactForm"');?>   
                    <ul class="con_us_ly_mian">
                      <li><span><em>*</em><?php ECHO FIBERSTORE_CONTACT_NAME;?></span>
                      <input type="text" name="contactname" class="big_input" reg="\w{2,}" tip="enter your full name please !" explain="<?php ECHO FIBERSTORE_CONTACT_CHECKNAME;?>"></li>
                    
                      <li><span><?php ECHO FIBERSTORE_CONTACT_PHONE;?></span>
                      <input type="text" name="phonenumber" class="big_input" explain="<?php ECHO FIBERSTORE_CONTACT_CHECKPHONE;?>"></li>
                    
                      <li><span><em>*</em><?php ECHO FIBERSTORE_CONTACT_EMAIL;?></span>
                      <input type="text" name="email" class="big_input" explain="<?php ECHO FIBERSTORE_CONTACT_CHECKEMAIL;?>"></li>

             
                      <li><span><em>*</em><?php ECHO FIBERSTORE_CONTACT_CEMAIL;?></span>
                      <input type="text" name="confirmemail" class="big_input" explain="FIBERSTORE_CONTACT_CEMAIL"></li>

                      <li><span><?php ECHO FIBERSTORE_CONTACT_REGARDING;?></span>
                      <select class="login_country"  name="dropdownSubject" id="dropdown-subject"><option value="default"><?php ECHO FIBERSTORE_CONTACT_SELECT;?></option><option value="returns"><?php ECHO FIBERSTORE_CONTACT_RETURNS;?></option><option value="order_status"><?php ECHO FIBERSTORE_CONTACT_ORDERSTATUS;?></option><option value="shipping"><?php ECHO FIBERSTORE_CONTACT_SHIPPING;?></option><option value="general_information"><?php ECHO FIBERSTORE_CONTACT_INFOMATION;?></option><option value="cancel_order"><?php ECHO FIBERSTORE_CONTACT_CANCEL;?></option><option value="espanol"><?php ECHO FIBERSTORE_CONTACT_ESPANOL;?></option><option value="international"><?php ECHO FIBERSTORE_CONTACT_INTERNATIONAL;?></option></select>
                      </li>


                      <li><span><?php ECHO FIBERSTORE_CONTACT_ORDER;?></span>
                      <input type="text" name="ordernumber" class="big_input" explain="<?php ECHO FIBERSTORE_CONTACT_CHECKORDER;?>"></li>

                      <li><span><?php ECHO FIBERSTORE_CONTACT_MESSAGE_SUBJECT;?></span>
                      <input type="text" name="subject" class="big_input" explain="<?php ECHO FIBERSTORE_CONTACT_CHECKMESSAGE;?>"></li>


                      <li class="height_01"><span><em>*</em><?php ECHO FIBERSTORE_CONTACT_QUESTIONS;?></span>
                      <textarea name="enquiry" class="login_014 aaa" explain="<?php echo FIBERSTORE_CONTACT_CHECKMESSAGE;?>"></textarea></li>

                    <li class="kong">
                    <input type="checkbox" name="send_me_too" value="0" id="checkbox_tk" explain="here will be 5 characters !">
                    <label class="checbox_wen" for="checkbox_tk"> E-mail una copia de este mensaje a su propio correo electrónico.</label></li>

                   <li class="height_02"><div class="set_button"><input type="submit" value="SUBMIT" class="button_02" style="margin-left: 200px"></div></li>
                    <div class="ccc"></div></ul>

                  </form>
                </div>
					
              </div>

            </div>
            </div>
                <div class="bbb">
    <?php  require($template->get_template_dir('tpl_oem_custom_default.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/'.'tpl_oem_custom_default.php');?>
    </div>
            
<?php  require($template->get_template_dir('tpl_account_right_default.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/'.'tpl_account_right_default.php');?>
            