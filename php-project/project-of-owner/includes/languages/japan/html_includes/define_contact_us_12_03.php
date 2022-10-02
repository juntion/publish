<!--  
  <div class="currentPath">
        	<a href="<?php echo zen_href_link(FILENAME_DEFAULT);?>">Home</a><em>></em><span>Contact Us</span>
        </div>

        <h1>Contact Us</h1>
        <p class="LH18px">We are happy to answer any questions you may have regarding our product offerings, your account, or any other service. You can reach us by phone, email, or live chat. All quote requests will be responded to within 24 hours at the latest.
        </p>
      	<div style="padding:15px 0;">
   	  	  	<dl class="Contact">
            <dt>Send Us an Email</dt>
            <dd>Pick from the topics below <br />that you would like to email <br />us about.</dd>
            </dl>
            <dl class="Contact">
            <dt>Give us a Call </dt>
            <dd>For web support or orders by phone:</dd>
            <dd class="Call">Call +86-75583003611</dd>
            </dl>
            <dl class="Contact">
            <dt>Live Chat</dt>
            <dd><a href="javascript:void(0)" onClick="javascript:window.open('http://chat8.live800.com/live800/chatClient/chatbox.jsp?companyID=152062&configID=124793&jid=2522617319&enterurl=http%3A%2F%2Fchat8%2Elive800%2Ecom%2Flive800%2Fpreview%2Ejsp&timestamp=1306208993183','','width=570,height=480')" style="cursor:hand" class="Chat">Click here for Live Chat. The hours of operation are 24/7 sales & support.</a></dd>
          	</dl>
            <div class="cb"></div>
      </div>
<?php echo zen_draw_form('contact_us', zen_href_link(FILENAME_CONTACT_US, 'action=send')); ?>
    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="30">Enter your Name:</td>
          </tr>
          <tr>
            <td><input name="contactname" type="text" class="input" /></td>
          </tr>
          <tr>
            <td height="30">E-mail address:</td>
          </tr>
          <tr>
            <td><input name="email" type="text" class="input" /></td>
          </tr>
          <tr>
            <td height="30">Message Subject:</td>
          </tr>
          <tr>
            <td><input name="subject" type="text" class="input" /></td>
          </tr>
          <tr>
            <td height="30">Enter your Message:</td>
          </tr>
         <tr>
            <td><textarea name="enquiry" cols="80" rows="10"></textarea></td>
          </tr>
          <tr>
            <td height="30"><input name="" type="checkbox" value="" /> E-mail a copy of this message to your own address.</td>
          </tr>
          <tr>
            <td height="30"><input type="submit" value="Send" class="btn1" /></td>
          </tr>
        </table>
        </from>
        
        -->
        
        
        






<?php
/**
 * contact us
 */?>
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
					$("input[name='"+fields_arr[i][1]+"']").css({'border':'2px dotted #C50001'}).focus();
					return false;
				}
				break;
			case 'textarea':
				var value = $("textarea[name='"+fields_arr[i][1]+"']").val();
				if('' == value || value.length < 3){
					$("textarea[name='"+fields_arr[i][1]+"']").css('border','2px dotted #C50001').focus();
					return false;
				}
				break;	
			case 'confirmemail':
				var patten = /^[a-z]+\@[a-z0-9]+\.[a-zA-Z]+$/;
				var value = $("input[name='"+fields_arr[i][1]+"']").val();
				if(!patten.test(value)){
					$("input[name='"+fields_arr[i][1]+"']").css('border','2px dotted #C50001').focus();
					return false;
					}
				break;		
			case 'email':
				var patten = /^[a-z]+\@[a-z0-9]+\.[a-zA-Z]+$/;
				var value = $("input[name='"+fields_arr[i][1]+"']").val();
				if(!patten.test(value)){
					$("input[name='"+fields_arr[i][1]+"']").css('border','2px dotted #C50001').focus();
					return false;
					}
				break;
		}
	
	
	}
	return true;
	
});
$("#checkbox_tk").click(function(){if($(this).is(":checked"))$(this).val(1);else $(this).val(0);});});
</script>
            <div class="about_main_bt1">
            
            <?php if ($messageStack->size('contact')) $messageStack->output('contact');?>
            <h1>Contact Us</h1>
            </div>
            <div class="about_main">
            We believe in the timeliness of customer service, and will do everything possible to satisfy our customers. We are happy to answer any questions you may have regarding our product offerings, your account, or any other service. You can reach us by phone, email, or live chat. All quote requests will be responded to within 24 hours at the latest. 
                <div class="contact">
			   <span class="contact_01 contact_05">Phone/Fax Numbers:</span>
			   Direct Line: 86-755-83003611<br />
               Fax: 86-755-83269395<br />
			   <span class="contact_02 contact_05">Email Address</span>
               Sales: <a href="mailto:sales@fiberstore.com">sales@fiberstore.com</a><br />
               Service Support: <a href="mailto:service@fiberstore.com">service@fiberstore.com</a><br />
			   <span class="contact_03 contact_05">Corporate Address:</span>
               FS.COM LIMITED<br />
               5-D Inteligent Tower, Fumin Rd., <br />
               Futian District, Shenzhen 518045, China<br />
			   <span class="contact_04 contact_05">Live Chat</span>
			   Click here for <a onclick="return live800.navigateToUrl('http://chat8.live800.com/live800/chatClient/chatbox.jsp?companyID=152062&configID=124793&jid=2522617319&enterurl=http%3A%2F%2Fwww%2Efiberstore%2Ecom%2F&timestamp=1333015627844&pagereferrer=', 'chatbox152062', globalWindowAttribute);" href="javascript:void(0);" rel="nofollow">Live Chat</a>. <br />
			   The hours of operation are 24/7 sales & support.<br />
</div>
               <div class="contact_rigth">

<iframe width="400" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Intelligent+Tower+Business+Center&amp;aq=&amp;sll=22.524172,114.065128&amp;sspn=0.002626,0.005252&amp;ie=UTF8&amp;hq=Intelligent+Tower+Business+Center&amp;hnear=&amp;t=m&amp;cid=4906616647687437477&amp;ll=22.534122,114.067526&amp;spn=0.023783,0.034332&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe>

</div>
			  
			  <div class="ccc"></div>
             <div class="con_us_lxfs">
                <div class="con_us_lxfs_tu con_tu_ly"></div>
                <div class="con_us_lxfs_wen">
                    <span class="con_us_lxfs_wen_bt">leave a Message</span>
                    <span class="con_us_lxfs_wen_zhu"><a href="javascript:void(0);">Fields marked with * are mandatory.</a></span>
                </div>
                <div class="con_us_ly_mian">
                <!--  
                <?php echo zen_draw_form('contactForm', zen_href_link(FILENAME_CONTACT_US,'&action=send&securityToken='.$_SESSION['securityToken'],''),'POST','id="contactForm"');?>
                 -->
              <?php echo zen_draw_form('contactForm', zen_href_link(FILENAME_CONTACT_US,'&action=send&securityToken='.$_SESSION['securityToken']),'POST','id="contactForm"');?>
                 
                  <table width="690px" cellspacing="0" cellpadding="0" border="0">
                    <tbody><tr>
                      <td width="140" align="right"><em>*</em>Enter your Name:</td>
                      <td width="550"><input type="text" name="contactname" class="input" reg="\w{2,}" tip="enter your full name please !" explain="Please check your name !"></td>
                      <td><!--<span id="err_contactname" style="display:none;">Please check your name !</span>
                      --></td>
                    </tr>
                    <!--<tr id="err_contactname" style="display:none;"><td colspan="3" style="margin-left:150px;">Please check your name !</td></tr>
                    -->
                    
                   <tr>
                      <td align="right">PHONE NUMBER: (OPTIONAL)</td>
                      <td><input type="text" name="phonenumber" class="input" explain="Please check your PHONE NUMBER: (OPTIONAL)  !"></td>
                      <td><!--<span id="err_phone" style="display:none;">Please check your E-mail address  !</span>
                      --></td>
                    </tr> 
                    
                    
                    
                    <tr>
                      <td align="right"><em>*</em>E-mail address:</td>
                      <td><input type="text" name="email" class="input" explain="Please check your E-mail address  !"></td>
                      <td><!--<span id="err_email" style="display:none;">Please check your E-mail address  !</span>
                      --></td>
                    </tr>
                    
                    <tr>
                      <td align="right"><em>*</em>Confirm your e-mail address :</td>
                      <td><input type="text" name="confirmemail" class="input" explain="Please check your E-mail address  !"></td>
                      <td><!--<span id="err_cemail" style="display:none;">Please check your E-mail address  !</span>
                      --></td>
                    </tr>
                    
                    <tr>
                      <td align="right">Order Number: (Optional)</td>
                      <td><input type="text" name="ordernumber" class="input" explain="Please check your Order Number: (Optional)  !"></td>
                      <td><!--<span id="err_order" style="display:none;">Please check your E-mail address  !</span>
                      --></td>
                    </tr>                    
                    
                    
                    <!--
                    <tr id="err_email" style="display:none"><td colspan="3">Please check your E-mail address !</td></tr>
                    --><tr>
                      <td align="right">Message Subject:</td>
                      <td><input type="text" name="subject" class="input" explain="Please check your message subject !"></td>
                      <td><!--<span id="err_subject" style="display:none;">Please check your message subject !</span>
                      --></td>
                    </tr><!--
                    <tr id="err_subject" style="display:none"><td colspan="3">Please check your message subject !</td></tr>
                    --><tr>
                      <td align="right"><em>*</em>Enter your Message:</td>
                      <td><textarea name="enquiry" class="con_us_ziti" explain="Please check your message content !"></textarea></td>
                    </tr>
                    <td><!--<span id="err_enquiry" style="display:none;">Please check your message content !</span>
                    --></td>
                    <td>
                    <span class="checbox_kaozuo">
                    <input type="checkbox" name="send_me_too" value="0" id="checkbox_tk" explain="here will be 5 characters !">
                    <label class="checbox_wen" for="checkbox_tk">E-mail a copy of this message to your own address.</label></span></td></tr>
                    <!--
                    <tr id="err_enquiry" style="display:none"><td colspan="3">Please check your message content !</td></tr>
                    --><tr>
                   <tr>
                    <td></td>
                    <td><input type="submit" value="Send" class="btn1"></td>
                    </tr>
                  </tbody></table>
                  </form>
                </div>
				<div class="ccc"></div>
              </div>

            </div>
