<?php
/**
 * contact us
 *  <link rel="stylesheet" type="text/css" href="includes/templates/fiberstore/css/help2.css"/>
  <link rel="stylesheet" type="text/css" href="includes/templates/fiberstore/css/contact_us.css"/>
 */?>
<style>
.button_02 {
margin-left: 200px;
}
</style>

 <script type="text/javascript">
$(function(){
var fields_arr = [['text','contactname',2],
	              ['email','email'],
	              ['confirmemail','confirmemail'],
	              ['text','subject',2],
	              ['textarea','enquiry',2]	
	              	              
	             ];
$("input[name='contactname']").blur(function(){$("input[name='contactname']").css('border','1px solid #CCC');$('#err_contactname').hide();});
$("input[name='email']").blur(function(){$("input[name='email']").css('border','1px solid #CCC');$('#err_email').hide();});
$("input[name='confirmemail']").blur(function(){$("input[name='confirmemail']").css('border','1px solid #CCC');$('#err_cemail').hide();});
$("input[name='subject']").blur(function(){$("input[name='subject']").css('border','1px solid #CCC');$('#err_subject').hide();});
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
            <div class="about_main_bt1">
            
            <?php if ($messageStack->size('contact')) $messageStack->output('contact');?>
            <h1>Cont芍ctenos</h1>
            </div>
            <div class="about_main">
            <p>Creemos en la oportunidad de la atenci車n al cliente, y har芍 todo lo posible para satisfacer a nuestros clientes. Estamos encantados de responder cualquier pregunta que usted pueda tener acerca de nuestra oferta de productos, su cuenta, o cualquier otro servicio. Puede comunicarse con nosotros por tel谷fono, correo electr車nico o chat en vivo. Todas las solicitudes de cotizaci車n ser芍n respondidas dentro de las 24 horas a m芍s tardar.</p>
                            <div class="contact">
			   <span class="contact_01 contact_05">Tel谷fono/Fax:</span>
			   <p>L赤nea directa: 86-755-83003611<br />
                Fax: 86-755-83269395</p>
			   <span class="contact_02 contact_05">Direcci車n de correo electr車nico</span>
               Sales: <a href="mailto:sales@fiberstore.com">sales@fiberstore.com</a><br />
               Service Support: <a href="mailto:service@fiberstore.com">service@fiberstore.com</a><br />
			   <span class="contact_03 contact_05">Direcci車n Corporativa:</span>
               <p>FIBERSTORE Co, Limited<br>
                  5-D Inteligent Tower, Fumin Rd.,<br>
                  Futian District, Shenzhen 518045, China</p>
			   <span class="contact_04 contact_05">Live Chat</span>
			<p>Haga clic aqu赤 para <a rel="nofollow" href="javascript:void(0);" onclick="return live800.navigateToUrl('http://chat8.live800.com/live800/chatClient/chatbox.jsp?companyID=152062&amp;configID=124793&amp;jid=2522617319&amp;enterurl=http%3A%2F%2Fwww%2Efiberstore%2Ecom%2F&amp;timestamp=1333015627844&amp;pagereferrer=', 'chatbox152062', globalWindowAttribute);">chatear en directo</a>. <br>
			   El horario de atenci車n es de 24/7 Soporte y Ventas.</p>
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
                    <span>leave a Message</span>
                    Fields marked with * are mandatory.
                </div>
				<div class="ccc"></div>
                <div class="con_us_ly_mian">
                <?php echo zen_draw_form('contactForm', zen_href_link(FILENAME_CONTACT_US,'&action=send&securityToken='.$_SESSION['securityToken']),'POST','id="contactForm"');?>
                    <ul class="con_us_ly_mian">
                      <li><span><em>*</em>Enter your Name:</span>
                      <input type="text" name="contactname" class="big_input" reg="\w{2,}" tip="enter your full name please !" explain="Please check your name !"></li>
                    
                      <li><span>PHONE NUMBER: (OPTIONAL)</span>
                      <input type="text" name="phonenumber" class="big_input" explain="Please check your PHONE NUMBER: (OPTIONAL)  !"></li>
                    
                      <li><span><em>*</em>E-mail address:</span>
                      <input type="text" name="email" class="big_input" explain="Please check your E-mail address  !"></li>

             
                      <li><span><em>*</em>Confirm your e-mail address :</span>
                      <input type="text" name="confirmemail" class="big_input" explain="Please check your E-mail address  !"></li>

                      <li><span>Regarding :</span>
                      <select class="login_country"  name="dropdownSubject" id="dropdown-subject"><option value="default">- please select one -</option><option value="returns">Returns</option><option value="order_status">Order Status</option><option value="shipping">Shipping</option><option value="general_information">General Information</option><option value="cancel_order">Cancel an Order</option><option value="espanol">Espanol</option><option value="international">International</option></select>
                      </li>


                      <li><span>Order Number: (Optional)</span>
                      <input type="text" name="ordernumber" class="big_input" explain="Please check your Order Number: (Optional)  !"></li>

                      <li><span>Message Subject:</span>
                      <input type="text" name="subject" class="big_input" explain="Please check your message subject !"></li>


                      <li class="height_01"><span><em>*</em>Comments/Questions:</span>
                      <textarea name="enquiry" class="login_014 aaa" explain="Please check your message content !"></textarea></li>

                    <li class="kong">
                    <input type="checkbox" name="send_me_too" value="0" id="checkbox_tk" explain="here will be 5 characters !">
                    <label class="checbox_wen" for="checkbox_tk"> E-mail una copia de este mensaje a su propio correo electr車nico.</label></li>

                   <li class="height_02"><div class="set_button"><input type="submit" value="SUBMIT" class="button_02"></div></li>
                    <div class="ccc"></div></ul>

                  </form>
                </div>
					
              </div>

            </div>
            </div>
<?php  require($template->get_template_dir('tpl_account_right_default.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/'.'tpl_account_right_default.php');?>
            